<?php

namespace Dash\Extras\Inputs;

use Dash\Extras\Inputs\Elements;
use Dash\Extras\Inputs\InputOptions\AdditionsToElements;
use Dash\Extras\Inputs\InputOptions\AddToFiltrationDataTable;
use Dash\Extras\Inputs\InputOptions\AstrotomicTranslatable;
use Dash\Extras\Inputs\InputOptions\Column;
use Dash\Extras\Inputs\InputOptions\ContractableAndRules;
use Dash\Extras\Inputs\InputOptions\CustomHtml;
use Dash\Extras\Inputs\InputOptions\DatatableOptions;
use Dash\Extras\Inputs\InputOptions\Dropzone;
use Dash\Extras\Inputs\InputOptions\FlatPicker;
use Dash\Extras\Inputs\InputOptions\HiddenOptions;
use Dash\Extras\Inputs\InputOptions\RelatedResources;
use Dash\Extras\Inputs\InputOptions\relationMethods;
use Dash\Extras\Inputs\InputOptions\Select;
use Dash\Extras\Inputs\InputOptions\ValidationRules;
use Dash\Extras\Inputs\InputOptions\VideoJsPlayer;

/**
 * Field Class
 *
 * Main class for creating and managing form input fields in PHPDash resources.
 * Provides a fluent interface for building inputs with various types, validations,
 * and display options through method chaining.
 *
 * Supports:
 * - Standard HTML inputs (text, textarea, select, etc.)
 * - File uploads (image, video, audio, dropzone)
 * - Date/time pickers (Flatpickr)
 * - Rich text editors (CKEditor)
 * - Eloquent relationships (belongsTo, hasMany, etc.)
 * - Polymorphic relationships (morphOne, morphMany, etc.)
 * - Custom HTML fields
 * - Multi-language support (Astrotomic Translatable)
 *
 * @package Dash\Extras\Inputs
 */
class Field
{
    use Elements,
        HiddenOptions,
        AddToFiltrationDataTable,
        Column,
        RelatedResources,
        DatatableOptions,
        Select,
        VideoJsPlayer,
        AstrotomicTranslatable,
        Dropzone,
        FlatPicker,
        relationMethods,
        ValidationRules,
        AdditionsToElements,
        CustomHtml,
        ContractableAndRules;

    /**
     * Registered inputs collection
     *
     * @var array
     */
    protected static $inputs = [];

    /**
     * Singleton instance for method chaining
     *
     * Holds the current Field instance to prevent creating
     * multiple instances during method chaining.
     *
     * @var self|null
     */
    protected static $instance = null;

    /**
     * Constructor
     *
     * @param string $type The input type
     * @param string|null $name The field name
     * @param string|null $attribute The field attribute
     * @param array|null $input The input data array
     */
    public function __construct($type, $name = null, $attribute = null, $input = null)
    {
        static::$type = $type;
    }

    /**
     * Check if input type is valid
     *
     * Validates that the provided type exists in the available element types.
     *
     * @param string $type The input type to check
     * @return bool True if valid, false otherwise
     */
    protected static function checkElementType($type)
    {
        return in_array($type, static::$element_types);
    }

    /**
     * Reset field options to defaults
     *
     * Resets all display and behavior options to their default values.
     * Called before creating each new field to ensure clean state.
     *
     * @return void
     */
    private static function resetOptions()
    {
        static::$showInIndex           = true;
        static::$showInShow            = true;
        static::$showInCreate          = true;
        static::$showInUpdate          = true;
        static::$disablePreviewButton  = true;
        static::$disableDwonloadButton = true;
        static::$deleteable            = true;
    }

    /**
     * Prepare input data structure
     *
     * Creates the initial data structure for a new input field.
     * Throws exception if an input with the same attribute already exists.
     *
     * @param string $name The field display name
     * @param string $attribute The field attribute/column name
     * @param mixed $resource The associated resource class
     * @return array The prepared input data structure
     *
     * @throws \Exception If input with attribute already exists
     */
    private static function prepareInputData($name, $attribute, $resource)
    {
        // Check for duplicate attributes
        if (isset(static::$inputs[$attribute])) {
            throw new \Exception("Input with attribute '$attribute' already exists.");
        }

        return [
            'type'       => static::$type,
            'name'       => $name,
            'attribute'  => $attribute,
            'column'     => static::$column,
            'orderable'  => true,
            'searchable' => true,
            'addToFilter' => false,
            'show_rules' => [
                'showInIndex'  => true,
                'showInCreate' => true,
                'showInUpdate' => true,
                'showInShow'   => true,
            ],
            'resource' => $resource,
        ];
    }

    /**
     * Create a new field instance
     *
     * Main static factory method for creating fields with fluent interface.
     * Initializes field configuration and enables method chaining.
     *
     * Usage:
     * ```php
     * Field::make('Name', 'name')->column(6)->rule('required')
     * ```
     *
     * @param string $name The field display name
     * @param string|null $attribute The field attribute/column name (auto-generated if null)
     * @param mixed $resource The associated resource class (for relationships)
     * @return self Field instance for method chaining
     *
     * @throws \Exception If input type is invalid
     */
    public static function make(string $name, ?string $attribute = null, $resource = null)
    {
        // Auto-generate attribute from name if not provided
        $attribute = empty($attribute) ?
            strtolower(str_replace(' ', '_', $name)) :
            $attribute;

        // Reset singleton instance for new field
        static::$instance = null;

        // Reset field options to defaults
        static::resetOptions();

        // Prepare input data structure
        $inputData = static::prepareInputData($name, $attribute, $resource);

        // Add resource if provided
        if (!empty($resource)) {
            $inputData['resource'] = $resource;
        }

        // Validate input type
        if (static::checkElementType(static::$type)) {
            static::$input[static::$index] = $inputData;
            static::$index++;
            return static::fillData();
        }

        // Throw exception for invalid type
        throw new \Exception(
            static::$type . ' incorrect. Please write a correct element like (' .
                implode(',', static::$element_types) . ')'
        );
    }

    /**
     * Get all registered inputs
     *
     * Returns the complete array of registered input fields.
     *
     * @return array All registered inputs
     */
    public static function getInputs()
    {
        return static::$inputs;
    }

    /**
     * Fill data and return field instance
     *
     * Updates field rules and returns the Field instance for method chaining.
     * Uses singleton pattern to prevent creating multiple instances during chaining.
     *
     * This method is called by all trait methods to enable fluent interface.
     *
     * @return self Field instance for method chaining
     */
    public static function fillData()
    {
        // Update field rules from current state
        static::UpdateRules();

        // Return singleton instance or create new one
        if (static::$instance === null) {
            static::$instance = new self(
                static::$type,
                static::$name,
                static::$attribute,
                static::$input
            );
        }

        return static::$instance;
    }

    /**
     * Handle undefined instance method calls
     *
     * Throws exception when calling non-existent instance methods.
     *
     * @param string $name The method name
     * @param array $arguments The method arguments
     * @return void
     *
     * @throws \Exception When method doesn't exist
     */
    public function __call($name, $arguments)
    {
        if (!method_exists($this, $name)) {
            throw new \Exception(
                '->' . $name . '() function undefined or not exists in dash project'
            );
        }
    }

    /**
     * Handle undefined static method calls
     *
     * Throws exception when calling non-existent static methods.
     *
     * @param string $name The method name
     * @param array $arguments The method arguments
     * @return void
     *
     * @throws \Exception When method doesn't exist
     */
    public static function __callStatic($name, $arguments)
    {
        if (!method_exists(Field::class, $name)) {
            throw new \Exception(
                '::' . $name . '() function undefined or not exists in dash project'
            );
        }
    }

    /**
     * Resolve dynamic value
     *
     * Helper method to resolve callable values or return static values.
     * Used throughout traits to handle both closures and direct values.
     *
     * @param mixed $value The value to resolve (callable or static)
     * @return mixed The resolved value
     */
    protected static function resolveValue($value)
    {
        return is_object($value) ? $value() : $value;
    }
}
