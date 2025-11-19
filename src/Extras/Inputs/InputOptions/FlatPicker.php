<?php

namespace Dash\Extras\Inputs\InputOptions;

/**
 * FlatPicker Trait
 *
 * Provides configuration methods for Flatpickr date/time picker.
 * Flatpickr is a lightweight, powerful datetime picker with no dependencies.
 *
 * Supports:
 * - Date selection (single, multiple, range)
 * - Time selection (12hr/24hr format)
 * - Min/max date restrictions
 * - Enable/disable specific dates
 * - Inline calendar display
 * - Custom formatting
 * - Localization
 *
 * @package Dash\Extras\Inputs\InputOptions
 * @link https://flatpickr.js.org/
 */
trait FlatPicker
{
    /**
     * Set date/time format
     *
     * Format tokens: Y (year), m (month), d (day), H (hour), i (minute), S (second)
     * Example: 'Y-m-d H:i:S' → '2024-01-15 14:30:00'
     *
     * @param string|callable $format Date/time format string
     * @return mixed Result of fillData()
     */
    public static function format($format)
    {
        static::$input[static::$index - 1]['format'] = static::resolveValue($format);
        return static::fillData();
    }

    /**
     * Enable time picker
     *
     * When enabled, shows time selection alongside date.
     *
     * @param bool|callable $enableTime Whether to enable time selection
     * @return mixed Result of fillData()
     */
    public static function enableTime($enableTime = true)
    {
        static::$input[static::$index - 1]['enableTime'] = static::resolveValue($enableTime);
        return static::fillData();
    }

    /**
     * Set minimum selectable date
     *
     * Dates before this will be disabled.
     *
     * @param string|callable $minDate Minimum date ('today', 'YYYY-MM-DD', or date string)
     * @return mixed Result of fillData()
     */
    public static function minDate($minDate = 'today')
    {
        static::$input[static::$index - 1]['minDate'] = static::resolveValue($minDate);
        return static::fillData();
    }

    /**
     * Set maximum selectable date
     *
     * Dates after this will be disabled.
     *
     * @param string|callable $maxDate Maximum date ('YYYY-MM-DD' or date string)
     * @return mixed Result of fillData()
     */
    public static function maxDate($maxDate)
    {
        static::$input[static::$index - 1]['maxDate'] = static::resolveValue($maxDate);
        return static::fillData();
    }

    /**
     * Disable specific dates
     *
     * Prevents selection of specified dates.
     *
     * Example: ['2024-01-15', '2024-01-20']
     *
     * @param array|callable $disableDates Array of dates to disable
     * @return mixed Result of fillData()
     */
    public static function disableDates($disableDates = [])
    {
        static::$input[static::$index - 1]['disableDates'] = static::resolveValue($disableDates);
        return static::fillData();
    }

    /**
     * Enable only specific dates
     *
     * Only specified dates will be selectable.
     *
     * Example: ['2024-01-15', '2024-01-20']
     *
     * @param array|callable $enableDates Array of dates to enable
     * @return mixed Result of fillData()
     */
    public static function enableDates($enableDates = [])
    {
        static::$input[static::$index - 1]['enableDates'] = static::resolveValue($enableDates);
        return static::fillData();
    }

    /**
     * Set date selection mode
     *
     * Modes:
     * - 'single' - Select one date
     * - 'multiple' - Select multiple dates
     * - 'range' - Select date range
     *
     * @param string|callable $modeDates Selection mode
     * @return mixed Result of fillData()
     */
    public static function modeDates($modeDates = 'multiple')
    {
        static::$input[static::$index - 1]['modeDates'] = static::resolveValue($modeDates);
        return static::fillData();
    }

    /**
     * Set default selected date(s)
     *
     * Pre-selects date(s) when picker opens.
     *
     * @param array|string|callable $defaultDate Default date(s)
     * @return mixed Result of fillData()
     */
    public static function defaultDate($defaultDate = [])
    {
        static::$input[static::$index - 1]['defaultDate'] = static::resolveValue($defaultDate);
        return static::fillData();
    }

    /**
     * Set conjunction for multiple dates
     *
     * Character to separate multiple dates in input.
     * Default: ',' → '2024-01-15,2024-01-20'
     *
     * @param string|callable $conjunction Separator character
     * @return mixed Result of fillData()
     */
    public static function conjunction($conjunction = ',')
    {
        static::$input[static::$index - 1]['conjunction'] = static::resolveValue($conjunction);
        return static::fillData();
    }

    /**
     * Hide calendar, show time picker only
     *
     * Useful for time-only selection.
     *
     * @param bool|callable $noCalendar Whether to hide calendar
     * @return mixed Result of fillData()
     */
    public static function noCalendar($noCalendar = true)
    {
        static::$input[static::$index - 1]['noCalendar'] = static::resolveValue($noCalendar);
        return static::fillData();
    }

    /**
     * Use 24-hour time format
     *
     * When false, uses 12-hour format with AM/PM.
     *
     * @param bool|callable $time_24hr Whether to use 24-hour format
     * @return mixed Result of fillData()
     */
    public static function time_24hr($time_24hr = true)
    {
        static::$input[static::$index - 1]['time_24hr'] = static::resolveValue($time_24hr);
        return static::fillData();
    }

    /**
     * Display picker inline
     *
     * Shows calendar directly in page instead of popup.
     *
     * @param bool|callable $inline Whether to display inline
     * @return mixed Result of fillData()
     */
    public static function inline($inline = true)
    {
        static::$input[static::$index - 1]['inline'] = static::resolveValue($inline);
        return static::fillData();
    }

    /**
     * Allow manual input
     *
     * When enabled, user can type date directly.
     *
     * @param bool|callable $allowInput Whether to allow manual input
     * @return mixed Result of fillData()
     */
    public static function allowInput($allowInput = true)
    {
        static::$input[static::$index - 1]['allowInput'] = static::resolveValue($allowInput);
        return static::fillData();
    }

    /**
     * Use alternate input format
     *
     * Shows human-readable format while storing different format.
     *
     * @param bool|callable $altInput Whether to use alternate format
     * @return mixed Result of fillData()
     */
    public static function altInput($altInput = true)
    {
        static::$input[static::$index - 1]['altInput'] = static::resolveValue($altInput);
        return static::fillData();
    }

    /**
     * Wrap mode for custom styling
     *
     * Required for custom button styling.
     *
     * @param bool|callable $wrap Whether to enable wrap mode
     * @return mixed Result of fillData()
     */
    public static function wrap($wrap = true)
    {
        static::$input[static::$index - 1]['wrap'] = static::resolveValue($wrap);
        return static::fillData();
    }

    /**
     * Show week numbers
     *
     * Displays week numbers in calendar.
     *
     * @param bool|callable $weekNumbers Whether to show week numbers
     * @return mixed Result of fillData()
     */
    public static function weekNumbers($weekNumbers = true)
    {
        static::$input[static::$index - 1]['weekNumbers'] = static::resolveValue($weekNumbers);
        return static::fillData();
    }

    /**
     * Set maximum selectable time
     *
     * Only valid when enableTime is true.
     * Format: 'HH:MM' (e.g., '18:30')
     *
     * @param string|callable $maxTime Maximum time
     * @return mixed Result of fillData()
     */
    public static function maxTime($maxTime = '')
    {
        static::$input[static::$index - 1]['maxTime'] = static::resolveValue($maxTime);
        return static::fillData();
    }

    /**
     * Set minimum selectable time
     *
     * Only valid when enableTime is true.
     * Format: 'HH:MM' (e.g., '09:00')
     *
     * @param string|callable $minTime Minimum time
     * @return mixed Result of fillData()
     */
    public static function minTime($minTime = '')
    {
        static::$input[static::$index - 1]['minTime'] = static::resolveValue($minTime);
        return static::fillData();
    }
}
