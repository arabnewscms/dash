<?php

namespace Dash;

use Illuminate\Http\Request;

/**
 * Abstract Pages Class
 *
 * Base class for creating custom dashboard pages outside the standard resource structure.
 * Extend this class to create blank pages with custom content and functionality.
 *
 * Pages can include forms, custom views, and data processing logic.
 * Supports nwidart/laravel-modules integration for module-based pages.
 *
 * @package Dash
 */
abstract class Pages
{
    use Modules;

    /**
     * The model associated with the page (if any)
     *
     * Used for pages that need to interact with a specific model,
     * such as settings pages or single-record editors.
     *
     * @var string|null
     */
    public static $model;

    /**
     * Icon for the page in navigation menu
     *
     * Can be a Font Awesome icon class or HTML tag.
     * Example: 'fa fa-cog' or '<i class="fa fa-cog"></i>'
     *
     * @var string|null
     */
    public static $icon;

    /**
     * Display page in navigation menu
     *
     * Set to false to hide the page from the sidebar navigation.
     *
     * @var bool
     */
    public static $displayInMenu = true;

    /**
     * Position in navigation menu
     *
     * Determines where the page appears in the navigation menu.
     * Options: 'top' (at the top) or 'bottom' (at the bottom)
     *
     * @var string
     */
    public static $position = 'top';

    /**
     * Success message after save
     *
     * Flash message displayed after successful data save operation.
     *
     * @var string
     */
    public static $successMessage = 'Saved';

    /**
     * Constructor
     *
     * Initializes the page and loads module resources if the page
     * belongs to a nwidart/laravel-modules module.
     */
    public function __construct()
    {
        // Use nwidart/laravel-modules localization and paths
        $this->initModule();
    }

    /**
     * Get validation rules
     *
     * Returns an array of Laravel validation rules for the page form.
     * Override this method in child classes to define validation rules.
     *
     * Example:
     * ```php
     * public static function rule()
     * {
     *     return [
     *         'site_name' => 'required|string|max:255',
     *         'site_email' => 'required|email',
     *         'logo' => 'nullable|image|max:2048'
     *     ];
     * }
     * ```
     *
     * @return array Validation rules array
     */
    public static function rule()
    {
        return [];
    }

    /**
     * Get custom attribute names
     *
     * Returns an array of custom attribute names for validation messages.
     * Override this method to provide user-friendly field names.
     *
     * Example:
     * ```php
     * public static function attribute()
     * {
     *     return [
     *         'site_name' => 'Site Name',
     *         'site_email' => 'Site Email Address'
     *     ];
     * }
     * ```
     *
     * @return array Custom attribute names for validation
     */
    public static function attribute()
    {
        return [];
    }

    /**
     * Get custom page name
     *
     * Returns the display name for the page shown in navigation and page title.
     * Override this method to provide a custom name, otherwise the class name is used.
     *
     * Example:
     * ```php
     * public static function pageName()
     * {
     *     return __('settings.general_settings');
     * }
     * ```
     *
     * @return string|null Custom page name
     */
    public static function pageName()
    {
        return null;
    }

    /**
     * Get page content
     *
     * Returns the view or HTML content for the page.
     * Override this method to define the page content and layout.
     *
     * Example:
     * ```php
     * public static function content()
     * {
     *     return view('settings.general', [
     *         'title' => static::pageName(),
     *         'settings' => Setting::first(),
     *     ]);
     * }
     * ```
     *
     * @return \Illuminate\View\View|string Page content
     */
    public static function content()
    {
        return view('{{name}}', [
            'title' => static::pageName(),
            // '{{name}}' => ModelName::find(1),
        ]);
    }

    /**
     * Save data to model
     *
     * Handles form submission and saves data to the associated model.
     * Automatically processes all request fields except _token, _method, and lang.
     * Handles file uploads and stores them in a directory named after the model.
     *
     * Process flow:
     * 1. Validates request data using rules from rule() method
     * 2. Finds the model record by ID
     * 3. Updates all fields from request
     * 4. Handles file uploads automatically
     * 5. Saves the model
     * 6. Flashes success message
     * 7. Redirects back
     *
     * @param \Illuminate\Http\Request $request The HTTP request
     * @param int|string $id The model record ID to update
     * @return \Illuminate\Http\RedirectResponse Redirect response
     *
     * @throws \Illuminate\Validation\ValidationException If validation fails
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If model not found
     */
    public static function save(Request $request, $id)
    {
        // Validate request if rules are defined
        if (!empty(static::rule()) && count(static::rule()) > 0) {
            $request->validate(static::rule(), static::attribute());
        }

        // Find the model record
        $data = static::$model::find($id);

        // Update fields from request
        foreach (request()->except(['_token', '_method', 'lang']) as $key => $value) {
            // Handle file uploads
            if (request()->hasFile($key)) {
                $data->{$key} = request()->file($key)->store(class_basename(static::$model));
            } else {
                $data->{$key} = $value;
            }
        }

        // Save the model
        $data->save();

        // Flash success message
        session()->flash('success', static::$successMessage);

        return back();
    }
}
