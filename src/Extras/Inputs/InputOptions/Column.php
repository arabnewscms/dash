<?php

namespace Dash\Extras\Inputs\InputOptions;

/**
 * Column Trait
 *
 * Provides methods for controlling field column width using Bootstrap grid system.
 *
 * @package Dash\Extras\Inputs\InputOptions
 */
trait Column
{
    /**
     * Default column width (Bootstrap grid: 1-12)
     *
     * @var int
     */
    public static $column = 12;

    /**
     * Set column width for all contexts
     *
     * @param int|callable $column Column width (1-12)
     * @return mixed Result of fillData()
     */
    public static function column($column = 12)
    {
        static::$input[static::$index - 1]['column'] = static::resolveValue($column);
        return static::fillData();
    }

    /**
     * Set column width specifically for create form
     *
     * @param int|callable $column Column width (1-12)
     * @return mixed Result of fillData()
     */
    public static function columnWhenCreate($column = 12)
    {
        static::$input[static::$index - 1]['columnWhenCreate'] = static::resolveValue($column);
        return static::fillData();
    }

    /**
     * Set column width specifically for update form
     *
     * @param int|callable $column Column width (1-12)
     * @return mixed Result of fillData()
     */
    public static function columnWhenUpdate($column = 12)
    {
        static::$input[static::$index - 1]['columnWhenUpdate'] = static::resolveValue($column);
        return static::fillData();
    }
}
