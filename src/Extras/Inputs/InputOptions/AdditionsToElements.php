<?php

namespace Dash\Extras\Inputs\InputOptions;

use function Opis\Closure\{serialize, unserialize};

/**
 * Additions To Elements Trait
 *
 * Provides additional configuration methods for form inputs including:
 * - Default values and placeholders
 * - File upload options
 * - Conditional visibility and behavior
 * - Custom callbacks for data manipulation
 * - Input attributes (readonly, disabled, etc.)
 *
 * @package Dash\Extras\Inputs\InputOptions
 */
trait AdditionsToElements
{
    /**
     * Set default value for input
     *
     * Used for both create and update if specific values not set.
     *
     * @param mixed|callable $value Default value
     * @return mixed Result of fillData()
     */
    public static function value($value = null)
    {
        static::$input[static::$index - 1]['value'] = static::resolveValue($value);
        return static::fillData();
    }

    /**
     * Set value only when creating
     *
     * Overrides general value() for create form.
     *
     * @param mixed|callable $value Value for create form
     * @return mixed Result of fillData()
     */
    public static function valueWhenCreate($value = null)
    {
        static::$input[static::$index - 1]['valueWhenCreate'] = static::resolveValue($value);
        return static::fillData();
    }

    /**
     * Set value only when updating
     *
     * Overrides general value() for update form.
     *
     * @param mixed|callable $value Value for update form
     * @return mixed Result of fillData()
     */
    public static function valueWhenUpdate($value = null)
    {
        static::$input[static::$index - 1]['valueWhenUpdate'] = static::resolveValue($value);
        return static::fillData();
    }

    /**
     * Set selected value for select inputs
     *
     * Pre-selects option in dropdown.
     *
     * @param mixed|callable $value Selected value
     * @return mixed Result of fillData()
     */
    public static function selected($value = null)
    {
        static::$input[static::$index - 1]['selected'] = static::resolveValue($value);
        return static::fillData();
    }

    /**
     * Set default value for checkbox/radio
     *
     * Pre-checks the checkbox or radio button.
     *
     * @param mixed|callable $value Default value
     * @return mixed Result of fillData()
     */
    public static function default($value = null)
    {
        static::$input[static::$index - 1]['default'] = static::resolveValue($value);
        return static::fillData();
    }

    /**
     * Set true value for checkbox
     *
     * Value to store when checkbox is checked.
     * Default: 1
     *
     * @param mixed|callable $value True value
     * @return mixed Result of fillData()
     */
    public static function trueVal($value = null)
    {
        static::$input[static::$index - 1]['trueVal'] = static::resolveValue($value);
        return static::fillData();
    }

    /**
     * Set false value for checkbox
     *
     * Value to store when checkbox is unchecked.
     * Default: 0
     *
     * @param mixed|callable $value False value
     * @return mixed Result of fillData()
     */
    public static function falseVal($value = null)
    {
        static::$input[static::$index - 1]['falseVal'] = static::resolveValue($value);
        return static::fillData();
    }

    /**
     * Set accepted file types
     *
     * For file upload inputs (file, image, video, audio).
     * Accepts MIME types or file extensions.
     *
     * Example: accept('image/*', '.pdf', 'video/mp4')
     *
     * @param string ...$accept Accepted file types
     * @return mixed Result of fillData()
     */
    public static function accept(...$accept)
    {
        static::$input[static::$index - 1]['accept'] = $accept;
        return static::fillData();
    }

    /**
     * Set upload path for file inputs
     *
     * Supports dynamic paths using {id} placeholder.
     * Example: 'uploads/users/{id}/images'
     *
     * @param string|callable $path Upload path
     * @return mixed Result of fillData()
     */
    public static function path($path)
    {
        static::$input[static::$index - 1]['path'] = [
            'serialize' => is_object($path),
            'source'    => is_object($path) ? serialize($path) : $path,
        ];

        return static::fillData();
    }

    /**
     * Custom callback when storing (creating)
     *
     * Modify data before saving to database on create.
     *
     * Example:
     * ```php
     * ->whenStore(function($value) {
     *     return strtoupper($value);
     * })
     * ```
     *
     * @param callable $whenStore Callback function
     * @return mixed Result of fillData()
     */
    public static function whenStore($whenStore)
    {
        static::$input[static::$index - 1]['whenStore'] = serialize($whenStore);
        return static::fillData();
    }

    /**
     * Custom callback when updating
     *
     * Modify data before saving to database on update.
     *
     * Example:
     * ```php
     * ->whenUpdate(function($value) {
     *     return trim($value);
     * })
     * ```
     *
     * @param callable $whenUpdate Callback function
     * @return mixed Result of fillData()
     */
    public static function whenUpdate($whenUpdate)
    {
        static::$input[static::$index - 1]['whenUpdate'] = serialize($whenUpdate);
        return static::fillData();
    }

    /**
     * Set textarea rows
     *
     * Number of visible text lines.
     *
     * @param int|callable $rows Number of rows
     * @return mixed Result of fillData()
     */
    public static function rows($rows)
    {
        static::$input[static::$index - 1]['rows'] = static::resolveValue($rows);
        return static::fillData();
    }

    /**
     * Set textarea columns
     *
     * Number of visible character columns.
     *
     * @param int|callable $cols Number of columns
     * @return mixed Result of fillData()
     */
    public static function cols($cols)
    {
        static::$input[static::$index - 1]['cols'] = static::resolveValue($cols);
        return static::fillData();
    }

    /**
     * Set text alignment
     *
     * CSS text-align values: left, right, center, justify
     *
     * @param string|callable $textAlign Text alignment
     * @return mixed Result of fillData()
     */
    public static function textAlign($textAlign)
    {
        static::$input[static::$index - 1]['textAlign'] = static::resolveValue($textAlign);
        return static::fillData();
    }

    /**
     * Disable input
     *
     * Prevents user interaction with the field.
     *
     * @param string|callable $disabled Disabled attribute value
     * @return mixed Result of fillData()
     */
    public static function disabled($disabled = "disabled")
    {
        static::$input[static::$index - 1]['disabled'] = static::resolveValue($disabled);
        return static::fillData();
    }

    /**
     * Set placeholder text
     *
     * Hint text shown when input is empty.
     *
     * @param string|callable $placeholder Placeholder text
     * @return mixed Result of fillData()
     */
    public static function placeholder($placeholder)
    {
        static::$input[static::$index - 1]['placeholder'] = static::resolveValue($placeholder);
        return static::fillData();
    }

    /**
     * Set help text
     *
     * Descriptive text shown below the input field.
     *
     * @param string|callable $help Help text
     * @return mixed Result of fillData()
     */
    public static function help($help)
    {
        static::$input[static::$index - 1]['help'] = static::resolveValue($help);
        return static::fillData();
    }

    /**
     * Make input readonly
     *
     * User can see but not modify the value.
     *
     * @param string|callable $readonly Readonly attribute value
     * @return mixed Result of fillData()
     */
    public static function readonly($readonly = 'readonly')
    {
        static::$input[static::$index - 1]['readonly'] = static::resolveValue($readonly);
        return static::fillData();
    }

    /**
     * Show field conditionally
     *
     * Field is shown only when condition is true.
     *
     * @param bool|callable $showIf Show condition
     * @return mixed Result of fillData()
     */
    public static function showIf($showIf)
    {
        static::$input[static::$index - 1]['showIf'] = static::resolveValue($showIf);
        return static::fillData();
    }

    /**
     * Hide field conditionally
     *
     * Field is hidden when condition is true.
     *
     * @param bool|callable $hideIf Hide condition
     * @return mixed Result of fillData()
     */
    public static function hideIf($hideIf)
    {
        static::$input[static::$index - 1]['hideIf'] = static::resolveValue($hideIf);
        return static::fillData();
    }

    /**
     * Check checkbox conditionally
     *
     * Checkbox is checked when condition is true.
     *
     * @param bool|callable $checkedIf Check condition
     * @return mixed Result of fillData()
     */
    public static function checkedIf($checkedIf)
    {
        static::$input[static::$index - 1]['checkedIf'] = static::resolveValue($checkedIf);
        return static::fillData();
    }

    /**
     * Make readonly conditionally
     *
     * Field becomes readonly when condition is true.
     *
     * @param bool|callable $readOnlyIf Readonly condition
     * @return mixed Result of fillData()
     */
    public static function readOnlyIf($readOnlyIf)
    {
        static::$input[static::$index - 1]['readOnlyIf'] = static::resolveValue($readOnlyIf);
        return static::fillData();
    }
}
