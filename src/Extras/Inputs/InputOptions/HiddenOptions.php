<?php

namespace Dash\Extras\Inputs\InputOptions;

/**
 * Hidden Options Trait
 *
 * Provides methods for controlling field visibility across different views
 * (index, show, create, update) and managing file-related options.
 *
 * @package Dash\Extras\Inputs\InputOptions
 */
trait HiddenOptions
{
    /**
     * Display rules for different views
     *
     * @var bool
     */
    protected static $showInIndex           = true;
    protected static $showInCreate          = true;
    protected static $showInUpdate          = true;
    protected static $showInShow            = true;
    protected static $disableDwonloadButton = true;
    protected static $disablePreviewButton  = true;
    protected static $deleteable            = true;

    /**
     * Show field only on index page
     *
     * Hides the field from show, create, and update views.
     *
     * @param bool|callable $condition Condition to evaluate
     * @return mixed Result of fillData()
     */
    public static function onlyIndex($condition = true)
    {
        static::resolveCondition($condition);
        static::$showInIndex  = true;
        static::$showInShow   = false;
        static::$showInCreate = false;
        static::$showInUpdate = false;

        return static::fillData();
    }

    /**
     * Show field only on forms (create and update)
     *
     * Hides the field from index and show views.
     *
     * @param bool|callable $condition Condition to evaluate
     * @return mixed Result of fillData()
     */
    public static function onlyForms($condition = true)
    {
        static::resolveCondition($condition);
        static::$showInIndex  = false;
        static::$showInShow   = false;
        static::$showInCreate = true;
        static::$showInUpdate = true;

        return static::fillData();
    }

    /**
     * Alias for onlyForms
     *
     * @param bool|callable $condition Condition to evaluate
     * @return mixed Result of fillData()
     */
    public static function onlyForm($condition = true)
    {
        return static::onlyForms($condition);
    }

    /**
     * Show field only on show page
     *
     * @param bool|callable $condition Condition to evaluate
     * @return mixed Result of fillData()
     */
    public static function onlyShow($condition = true)
    {
        $result = static::resolveCondition($condition);

        if ($result) {
            static::$showInIndex  = true;
            static::$showInShow   = true;
            static::$showInCreate = false;
            static::$showInUpdate = false;
        } else {
            static::$showInIndex  = true;
            static::$showInShow   = true;
            static::$showInCreate = true;
            static::$showInUpdate = true;
        }

        return static::fillData();
    }

    /**
     * Show field on index page
     *
     * @param bool|callable $condition Condition to evaluate
     * @return mixed Result of fillData()
     */
    public static function showInIndex($condition = true)
    {
        static::$showInIndex = static::resolveCondition($condition);
        return static::fillData();
    }

    /**
     * Show field on create page
     *
     * @param bool|callable $condition Condition to evaluate
     * @return mixed Result of fillData()
     */
    public static function showInCreate($condition = true)
    {
        static::$showInCreate = static::resolveCondition($condition);
        return static::fillData();
    }

    /**
     * Show field on update page
     *
     * @param bool|callable $condition Condition to evaluate
     * @return mixed Result of fillData()
     */
    public static function showInUpdate($condition = true)
    {
        static::$showInUpdate = static::resolveCondition($condition);
        return static::fillData();
    }

    /**
     * Show field on show page
     *
     * @param bool|callable $condition Condition to evaluate
     * @return mixed Result of fillData()
     */
    public static function showInShow($condition = true)
    {
        static::$showInShow = static::resolveCondition($condition);
        return static::fillData();
    }

    /**
     * Show field on all pages
     *
     * @param bool|callable $condition Condition to evaluate
     * @return mixed Result of fillData()
     */
    public static function showInAll($condition = true)
    {
        $result = static::resolveCondition($condition);

        if ($result) {
            static::$showInIndex  = true;
            static::$showInShow   = true;
            static::$showInCreate = true;
            static::$showInUpdate = true;
        }

        return static::fillData();
    }

    /**
     * Hide field from all pages
     *
     * @param bool|callable $condition Condition to evaluate
     * @return mixed Result of fillData()
     */
    public static function hideInAll($condition = true)
    {
        $result = static::resolveCondition($condition);

        if ($result) {
            static::$showInIndex  = false;
            static::$showInShow   = false;
            static::$showInCreate = false;
            static::$showInUpdate = false;
        }

        return static::fillData();
    }

    /**
     * Hide field from index page
     *
     * @param bool|callable $condition Condition to evaluate
     * @return mixed Result of fillData()
     */
    public static function hideInIndex($condition = true)
    {
        $result = static::resolveCondition($condition);

        if ($result) {
            static::$showInIndex = false;
        }

        return static::fillData();
    }

    /**
     * Hide field from create page
     *
     * @param bool|callable $condition Condition to evaluate
     * @return mixed Result of fillData()
     */
    public static function hideInCreate($condition = true)
    {
        $result = static::resolveCondition($condition);

        if ($result) {
            static::$showInCreate = false;
        }

        return static::fillData();
    }

    /**
     * Hide field from update page
     *
     * @param bool|callable $condition Condition to evaluate
     * @return mixed Result of fillData()
     */
    public static function hideInUpdate($condition = true)
    {
        $result = static::resolveCondition($condition);

        if ($result) {
            static::$showInUpdate = false;
        }

        return static::fillData();
    }

    /**
     * Hide field from show page
     *
     * @param bool|callable $condition Condition to evaluate
     * @return mixed Result of fillData()
     */
    public static function hideInShow($condition = true)
    {
        $result = static::resolveCondition($condition);

        if ($result) {
            static::$showInShow = false;
        }

        return static::fillData();
    }

    /**
     * Disable preview button for file inputs
     *
     * @param bool|callable $condition Condition to evaluate
     * @return mixed Result of fillData()
     */
    public static function disablePreviewButton($condition = true)
    {
        $result = static::resolveCondition($condition);

        if ($result) {
            static::$disablePreviewButton = false;
        }

        return static::fillData();
    }

    /**
     * Disable download button for file inputs
     *
     * @param bool|callable $condition Condition to evaluate
     * @return mixed Result of fillData()
     */
    public static function disableDownloadButton($condition = true)
    {
        $result = static::resolveCondition($condition);

        if ($result) {
            static::$disableDwonloadButton = false;
        }

        return static::fillData();
    }

    /**
     * Set if file is deleteable
     *
     * @param bool|callable $condition Condition to evaluate
     * @return mixed Result of fillData()
     */
    public static function deleteable($condition = true)
    {
        static::$deleteable = static::resolveCondition($condition);
        return static::fillData();
    }

    /**
     * Alias for deleteable (British spelling)
     *
     * @param bool|callable $condition Condition to evaluate
     * @return mixed Result of fillData()
     */
    public static function deletable($condition = true)
    {
        static::$deleteable = static::resolveCondition($condition);
        return static::fillData();
    }

    /**
     * Resolve condition value
     *
     * Evaluates callable conditions or returns boolean value directly.
     *
     * @param bool|callable $condition The condition to resolve
     * @return bool The resolved boolean value
     */
    protected static function resolveCondition($condition)
    {
        return is_object($condition) ? $condition() : $condition;
    }

    /**
     * Update field rules in input array
     *
     * Called by fillData() to persist current state to input array.
     *
     * @return void
     */
    public static function UpdateRules()
    {
        static::$input[static::$index - 1]['deleteable']            = static::$deleteable;
        static::$input[static::$index - 1]['disableDwonloadButton'] = static::$disableDwonloadButton;
        static::$input[static::$index - 1]['disablePreviewButton']  = static::$disablePreviewButton;

        static::$input[static::$index - 1]['show_rules'] = [
            'showInIndex'  => static::$showInIndex,
            'showInCreate' => static::$showInCreate,
            'showInUpdate' => static::$showInUpdate,
            'showInShow'   => static::$showInShow,
        ];
    }
}
