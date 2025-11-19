<?php

/**
 * Dash Input Helpers
 *
 * Helper functions for creating form input fields within Dash resources.
 * These functions provide a fluent interface for building form inputs
 * with various types including standard HTML inputs, relationships, and custom fields.
 *
 * @package Dash
 */

if (!function_exists('dash_init_input')) {
    /**
     * Initialize a new input field
     *
     * Core function that creates and returns a Field instance for the specified input type.
     * Can be called with or without parameters for flexible field creation.
     *
     * @param string $input_type The type of input field to create
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration for the field
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function dash_init_input($input_type, $name = null, $attribute = null, $resource = null)
    {
        if (!empty($name) || !empty($attribute) || !empty($resource)) {
            return (new \Dash\Extras\Inputs\Field($input_type))->make($name, $attribute, $resource);
        }

        return new \Dash\Extras\Inputs\Field($input_type);
    }
}

if (!function_exists('field')) {
    /**
     * Create a generic input field
     *
     * Generic field creator that accepts any input type.
     * Defaults to 'text' input if no type is specified.
     *
     * @param string $input_type The type of input field (default: 'text')
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function field($input_type = 'text', $name = null, $attribute = null, $resource = null)
    {
        return dash_init_input($input_type, $name, $attribute, $resource);
    }
}

if (!function_exists('id')) {
    /**
     * Create an ID input field
     *
     * Creates a hidden or readonly input field for model IDs.
     * Typically used for primary key fields.
     *
     * @param string|null $name The name attribute (default: 'id')
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function id($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('id', $name, $attribute, $resource);
    }
}

if (!function_exists('text')) {
    /**
     * Create a text input field
     *
     * Standard single-line text input field.
     *
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function text($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('text', $name, $attribute, $resource);
    }
}

if (!function_exists('hidden')) {
    /**
     * Create a hidden input field
     *
     * Hidden input field for passing data without display.
     *
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $value The value to be stored in the hidden field
     * @return \Dash\Extras\Inputs\Field
     */
    function hidden($name = null, $value = null)
    {
        return dash_init_input('hidden', $name, $value);
    }
}

if (!function_exists('textarea')) {
    /**
     * Create a textarea input field
     *
     * Multi-line text input field for longer content.
     *
     * @param string|null $name The name attribute of the textarea
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function textarea($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('textarea', $name, $attribute, $resource);
    }
}

if (!function_exists('ckeditor')) {
    /**
     * Create a CKEditor WYSIWYG field
     *
     * Rich text editor field using CKEditor for formatted content.
     * Ideal for blog posts, articles, and HTML content.
     *
     * @param string|null $name The name attribute of the editor field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function ckeditor($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('ckeditor', $name, $attribute, $resource);
    }
}

if (!function_exists('uri')) {
    /**
     * Create a URL input field
     *
     * Input field specifically for URL/URI values with validation.
     *
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function uri($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('url', $name, $attribute, $resource);
    }
}

if (!function_exists('search')) {
    /**
     * Create a search input field
     *
     * HTML5 search input with search-specific styling and behavior.
     *
     * @param string|null $name The name attribute of the search field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function search($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('search', $name, $attribute, $resource);
    }
}

if (!function_exists('number')) {
    /**
     * Create a number input field
     *
     * Numeric input field with optional min, max, and step attributes.
     *
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function number($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('number', $name, $attribute, $resource);
    }
}

if (!function_exists('week')) {
    /**
     * Create a week picker input field
     *
     * HTML5 week selector for choosing specific weeks.
     *
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function week($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('week', $name, $attribute, $resource);
    }
}

if (!function_exists('month')) {
    /**
     * Create a month picker input field
     *
     * HTML5 month selector for choosing specific months.
     *
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function month($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('month', $name, $attribute, $resource);
    }
}

if (!function_exists('tel')) {
    /**
     * Create a telephone input field
     *
     * HTML5 tel input optimized for phone number entry.
     *
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function tel($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('tel', $name, $attribute, $resource);
    }
}

if (!function_exists('select')) {
    /**
     * Create a select dropdown field
     *
     * Dropdown selection field with customizable options.
     *
     * @param string|null $name The name attribute of the select field
     * @param mixed|null $attribute Additional attributes or configuration (options, etc.)
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function select($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('select', $name, $attribute, $resource);
    }
}

if (!function_exists('email')) {
    /**
     * Create an email input field
     *
     * HTML5 email input with built-in email validation.
     *
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function email($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('email', $name, $attribute, $resource);
    }
}

if (!function_exists('image')) {
    /**
     * Create an image upload field
     *
     * File upload field specifically for image files with preview capability.
     *
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function image($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('image', $name, $attribute, $resource);
    }
}

if (!function_exists('password')) {
    /**
     * Create a password input field
     *
     * Secure password input field with masked characters.
     *
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function password($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('password', $name, $attribute, $resource);
    }
}

if (!function_exists('checkbox')) {
    /**
     * Create a checkbox input field
     *
     * Boolean checkbox input for true/false or yes/no values.
     *
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function checkbox($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('checkbox', $name, $attribute, $resource);
    }
}

if (!function_exists('fileUpload')) {
    /**
     * Create a file upload field
     *
     * Generic file upload field for any file type.
     *
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function fileUpload($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('file', $name, $attribute, $resource);
    }
}

if (!function_exists('video')) {
    /**
     * Create a video upload field
     *
     * File upload field specifically for video files with player integration.
     *
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function video($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('video', $name, $attribute, $resource);
    }
}

if (!function_exists('audio')) {
    /**
     * Create an audio upload field
     *
     * File upload field specifically for audio files with player integration.
     *
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function audio($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('audio', $name, $attribute, $resource);
    }
}

if (!function_exists('color')) {
    /**
     * Create a color picker field
     *
     * HTML5 color input with visual color picker interface.
     *
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function color($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('color', $name, $attribute, $resource);
    }
}

if (!function_exists('dropzone')) {
    /**
     * Create a Dropzone file upload field
     *
     * Advanced drag-and-drop file upload interface using Dropzone.js.
     * Supports multiple files, drag-and-drop, and file previews.
     *
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function dropzone($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('dropzone', $name, $attribute, $resource);
    }
}

if (!function_exists('fullDate')) {
    /**
     * Create a date picker field
     *
     * Date selector with calendar interface using Flatpickr.
     *
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function fullDate($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('date', $name, $attribute, $resource);
    }
}

if (!function_exists('fullTime')) {
    /**
     * Create a time picker field
     *
     * Time selector with clock interface using Flatpickr.
     *
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function fullTime($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('time', $name, $attribute, $resource);
    }
}

if (!function_exists('fullDateTime')) {
    /**
     * Create a datetime picker field
     *
     * Combined date and time selector using Flatpickr.
     *
     * @param string|null $name The name attribute of the input field
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function fullDateTime($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('datetime', $name, $attribute, $resource);
    }
}

// ============================================
// Eloquent Relationship Input Helpers
// ============================================

if (!function_exists('hasOneThrough')) {
    /**
     * Create a hasOneThrough relationship field
     *
     * Represents a Laravel hasOneThrough relationship in the form.
     * Used for accessing distant relations through an intermediate model.
     *
     * @param string|null $name The relationship method name
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function hasOneThrough($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('hasOneThrough', $name, $attribute, $resource);
    }
}

if (!function_exists('hasOne')) {
    /**
     * Create a hasOne relationship field
     *
     * Represents a Laravel hasOne relationship in the form.
     * One-to-one relationship where the parent has one related model.
     *
     * @param string|null $name The relationship method name
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function hasOne($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('hasOne', $name, $attribute, $resource);
    }
}

if (!function_exists('hasManyThrough')) {
    /**
     * Create a hasManyThrough relationship field
     *
     * Represents a Laravel hasManyThrough relationship in the form.
     * Used for accessing distant relations through an intermediate model.
     *
     * @param string|null $name The relationship method name
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function hasManyThrough($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('hasManyThrough', $name, $attribute, $resource);
    }
}

if (!function_exists('hasMany')) {
    /**
     * Create a hasMany relationship field
     *
     * Represents a Laravel hasMany relationship in the form.
     * One-to-many relationship where the parent has multiple related models.
     *
     * @param string|null $name The relationship method name
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function hasMany($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('hasMany', $name, $attribute, $resource);
    }
}

if (!function_exists('belongsTo')) {
    /**
     * Create a belongsTo relationship field
     *
     * Represents a Laravel belongsTo relationship in the form.
     * Inverse of hasOne/hasMany - the child belongs to a parent model.
     *
     * @param string|null $name The relationship method name
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function belongsTo($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('belongsTo', $name, $attribute, $resource);
    }
}

if (!function_exists('belongsToMany')) {
    /**
     * Create a belongsToMany relationship field
     *
     * Represents a Laravel belongsToMany relationship in the form.
     * Many-to-many relationship using a pivot table.
     *
     * @param string|null $name The relationship method name
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function belongsToMany($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('belongsToMany', $name, $attribute, $resource);
    }
}

if (!function_exists('morphOne')) {
    /**
     * Create a morphOne relationship field
     *
     * Represents a Laravel morphOne polymorphic relationship in the form.
     * One-to-one polymorphic relationship.
     *
     * @param string|null $name The relationship method name
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function morphOne($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('morphOne', $name, $attribute, $resource);
    }
}

if (!function_exists('morphTo')) {
    /**
     * Create a morphTo relationship field
     *
     * Represents a Laravel morphTo polymorphic relationship in the form.
     * Inverse of morphOne/morphMany.
     *
     * @param string|null $name The relationship method name
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function morphTo($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('morphTo', $name, $attribute, $resource);
    }
}

if (!function_exists('morphToMany')) {
    /**
     * Create a morphToMany relationship field
     *
     * Represents a Laravel morphToMany polymorphic relationship in the form.
     * Many-to-many polymorphic relationship.
     *
     * @param string|null $name The relationship method name
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function morphToMany($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('morphToMany', $name, $attribute, $resource);
    }
}

if (!function_exists('morphMany')) {
    /**
     * Create a morphMany relationship field
     *
     * Represents a Laravel morphMany polymorphic relationship in the form.
     * One-to-many polymorphic relationship.
     *
     * @param string|null $name The relationship method name
     * @param mixed|null $attribute Additional attributes or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function morphMany($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('morphMany', $name, $attribute, $resource);
    }
}

if (!function_exists('custom')) {
    /**
     * Create a custom HTML field
     *
     * Allows insertion of custom HTML content within the form.
     * Useful for custom widgets, instructions, or specialized inputs.
     *
     * @param string|null $name The name/identifier for the custom field
     * @param mixed|null $attribute HTML content or configuration
     * @param mixed|null $resource The resource model this field belongs to
     * @return \Dash\Extras\Inputs\Field
     */
    function custom($name = null, $attribute = null, $resource = null)
    {
        return dash_init_input('customHtml', $name, $attribute, $resource);
    }
}

// ============================================
// Utility Helper Functions
// ============================================

if (!function_exists('dash')) {
    /**
     * Generate a dashboard URL
     *
     * Creates a full URL to a dashboard route by prepending the
     * configured dashboard path to the given segments.
     *
     * @param string $segments The URL segments to append to dashboard path
     * @return string The complete dashboard URL
     *
     * @example dash('/users') // Returns: http://example.com/dashboard/users
     * @example dash('users/create') // Returns: http://example.com/dashboard/users/create
     */
    function dash($segments)
    {
        if (substr($segments, 0, 1) === '/') {
            return url(config('dash.DASHBOARD_PATH') . $segments);
        }

        return url(config('dash.DASHBOARD_PATH') . '/' . $segments);
    }
}

if (!function_exists('admin')) {
    /**
     * Get the authenticated admin user
     *
     * Returns the currently authenticated user from the specified guard.
     * Merges dashboard guard configuration before authentication check.
     *
     * @param string $guard The authentication guard name (default: 'dash')
     * @return \Illuminate\Contracts\Auth\Authenticatable|null The authenticated admin user or null
     */
    function admin($guard = 'dash')
    {
        $dashGuard = config('auth.guards');
        $dashGuard = array_merge(config('dash.GUARD'), $dashGuard);
        \Config::set('auth.guards', $dashGuard);

        return auth()->guard($guard)->user();
    }
}

if (!function_exists('resourceShortName')) {
    /**
     * Get the short class name of a resource
     *
     * Extracts and returns the class name without namespace.
     * If the class doesn't exist, returns the input as-is.
     *
     * @param string $resource The fully qualified class name or resource identifier
     * @return string The short class name without namespace
     *
     * @example resourceShortName('App\Resources\UserResource') // Returns: 'UserResource'
     */
    function resourceShortName($resource)
    {
        if (class_exists($resource)) {
            return (new \ReflectionClass($resource))->getShortName();
        }

        return $resource;
    }
}

if (!function_exists('searchInFields')) {
    /**
     * Search for a specific field in a fields array
     *
     * Searches through an array of field definitions to find a field
     * matching the specified column name. Supports dot notation for
     * nested attributes.
     *
     * @param string $column The column name to search for
     * @param array $fields The array of field definitions to search through
     * @param string $columnTarget The key name to search within (default: 'attribute')
     * @return array|false The matching field definition or false if not found
     *
     * @example searchInFields('user.name', $fields) // Finds field with attribute 'user.name'
     */
    function searchInFields($column, $fields, $columnTarget = 'attribute')
    {
        foreach ($fields as $fetchField) {
            $attribute = explode('.', $fetchField[$columnTarget]);

            if (!empty($attribute) && count($attribute) > 0) {
                if ($attribute[0] === $column) {
                    return $fetchField;
                }
            }
        }

        return false;
    }
}

if (!function_exists('dash_check_range_date_input')) {
    /**
     * Check and parse date range input
     *
     * Validates and parses date strings to determine if they represent
     * a date range or multiple dates. Supports both English and Arabic
     * separators ('to', 'إلى', 'الى').
     *
     * @param string $string The date string to parse
     * @return array|false Array with 'dates' and 'multiple' keys, or false if invalid
     *
     * @example
     * dash_check_range_date_input('2024-01-01 to 2024-01-31')
     * // Returns: ['dates' => ['2024-01-01 00:00:00', '2024-01-31 00:00:00'], 'multiple' => false]
     *
     * @example
     * dash_check_range_date_input('2024-01-01,2024-01-15,2024-01-31')
     * // Returns: ['dates' => ['2024-01-01', '2024-01-15', '2024-01-31'], 'multiple' => true]
     */
    function dash_check_range_date_input(string $string): array|bool
    {
        $string = strtolower($string);
        $pattern = '/\b\d{4}-\d{2}-(0[1-9]|[12][0-9]|3[01])\b/';
        $checkIsDate = preg_match($pattern, $string);

        if (!$checkIsDate) {
            return false;
        }

        // Replace range separators with pipe
        $cleanedString = str_replace(['to', 'إلى', 'الى'], '|', $string);
        $cleanedString = explode('|', $cleanedString);

        // Check if it's a date range (two dates)
        if (isset($cleanedString[1]) && !empty($cleanedString[1])) {
            $cleanedString = [
                date('Y-m-d H:i:s', strtotime($cleanedString[0])),
                date('Y-m-d H:i:s', strtotime($cleanedString[1]))
            ];
            return ['dates' => $cleanedString, 'multiple' => false];
        }

        // Check if it's multiple dates (comma-separated)
        $cleanedString = explode(',', $string);
        if (count($cleanedString) > 0) {
            return ['dates' => $cleanedString, 'multiple' => true];
        }

        return false;
    }
}

if (!function_exists('lara_module')) {
    /**
     * Check Laravel Modules package version
     *
     * Determines if nwidart/laravel-modules is installed and if its
     * version is greater than the specified version.
     *
     * @param string $v The version to compare against (default: '10.0.0')
     * @return bool True if installed and version is greater, false otherwise
     *
     * @example lara_module('11.0.0') // Returns true if version > 11.0.0
     */
    function lara_module($v = '10.0.0')
    {
        if (!\Composer\InstalledVersions::isInstalled('nwidart/laravel-modules')) {
            return false;
        }

        $checkModuleVersion = \Composer\InstalledVersions::getVersion('nwidart/laravel-modules');
        return version_compare($checkModuleVersion, $v, '>');
    }
}

// ============================================
// Commented/Disabled Functions
// These are kept for reference but not currently in use
// ============================================

// if (!function_exists('dash_update_json_setting')) {
//     /**
//      * Update a value in the JSON settings file
//      *
//      * @param string $key The setting key to update
//      * @param mixed $value The new value
//      * @return void
//      */
//     function dash_update_json_setting($key, $value)
//     {
//         $filePath = '/dash/config/settings.json';
//         $configArray = dash_get_json_setting();
//
//         // Update the specific key
//         $configArray[$key] = $value;
//
//         // Save back to the file
//         \Storage::put($filePath, json_encode($configArray, JSON_PRETTY_PRINT));
//     }
// }

// if (!function_exists('ip_as_serial')) {
//     /**
//      * Convert IP address to serial number format
//      *
//      * @return string IP address with dots and colons removed
//      */
//     function ip_as_serial()
//     {
//         return str_replace(['.', ':'], '', request()->ip());
//     }
// }

// if (!function_exists('dash_get_json_setting')) {
//     /**
//      * Get a value from the JSON settings file
//      *
//      * @param string|null $key The setting key to retrieve (null for all settings)
//      * @return mixed The setting value, empty string if not found, or all settings array
//      */
//     function dash_get_json_setting($key = null)
//     {
//         $filePath = '/dash/config/settings.json';
//         $configArray = [];
//
//         // Load existing settings if the file exists
//         if (\Storage::exists($filePath)) {
//             $fileContents = \Storage::get($filePath);
//             $configArray = json_decode($fileContents, true);
//         } elseif (!\Storage::exists($filePath)) {
//             \Storage::put($filePath, json_encode($configArray, JSON_PRETTY_PRINT));
//             $fileContents = \Storage::get($filePath);
//             $configArray = json_decode($fileContents, true);
//         }
//
//         // Return specific key or all settings
//         if (!empty($key)) {
//             return $configArray[$key] ?? '';
//         }
//
//         return $configArray;
//     }
// }
