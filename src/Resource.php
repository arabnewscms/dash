<?php

declare(strict_types=1);

namespace Dash;

use Dash\Extras\Dashboard\Dashboard;
use Dash\Extras\Inputs\InputOptions\relationTypes;
use Dash\Extras\Resources\MainResource;

/**
 * Resource Class
 *
 * Base class for all dashboard resources providing CRUD functionality.
 * Handles dynamic property access, model data retrieval, and method delegation.
 *
 * Features:
 * - Dynamic property access from models
 * - AJAX request handling
 * - Model data caching
 * - Method delegation to model instances
 * - Module integration support
 *
 * @package Dash
 */
class Resource
{
    use Dashboard, MainResource, relationTypes, Modules;

    /**
     * Cached model data instance
     *
     * Stores the loaded model to prevent redundant database queries.
     *
     * @var \Illuminate\Database\Eloquent\Model|null
     */
    protected static $model_data;

    /**
     * Cached record ID
     *
     * @var int|null
     */
    protected $cachedId;

    /**
     * Constructor
     *
     * Initializes the resource and loads module configuration
     * if using nwidart/laravel-modules.
     */
    public function __construct()
    {
        // Use nwidart/laravel-modules localization and paths
        $this->initModule();
    }

    /**
     * Magic getter for dynamic property access
     *
     * Retrieves property values from the associated model.
     * Handles both AJAX and regular requests.
     *
     * @param string $property Property name to retrieve
     * @return mixed Property value or null
     */
    public function __get($property)
    {
        // Handle AJAX requests
        if (request()->ajax()) {
            return $this->getPropertyFromAjaxRequest($property);
        }

        // Handle regular requests
        return $this->getPropertyFromRequest($property);
    }

    /**
     * Get property value from AJAX request
     *
     * @param string $property Property name
     * @return mixed Property value or null
     */
    protected function getPropertyFromAjaxRequest($property)
    {
        $object = str_replace('._.', '\\', get_class($this)::$model);
        $recordId = request('record_id');
        $attribute = request('attribute');

        if (!class_exists($object) || empty($attribute)) {
            return $this->getPropertyFromRequest($property);
        }

        // Try to get property directly from model
        $modelData = app($object)::find($recordId);

        if (!empty($modelData) && !empty($modelData->$property)) {
            static::$model_data = $modelData;
            return $this->$property = $modelData->$property;
        }

        // Try with eager loading
        return $this->getPropertyWithRelation($object, $recordId, $attribute, $property);
    }

    /**
     * Get property with eager loaded relationship
     *
     * @param string $object Model class name
     * @param int $recordId Record ID
     * @param string $attribute Relationship attribute
     * @param string $property Property name
     * @return mixed Property value or null
     */
    protected function getPropertyWithRelation($object, $recordId, $attribute, $property)
    {
        $modelData = app($object)::where('id', $recordId)
            ->with($attribute)
            ->pluck($property);

        if (empty($modelData)) {
            return null;
        }

        // Return first item if exists
        if (!empty($modelData[0])) {
            static::$model_data = $modelData[0];
            return $this->$property = $modelData[0];
        }

        // Handle string response
        if (is_string($modelData)) {
            $preparedData = str_replace(['"]', '\\["'], '', $modelData);
            static::$model_data = $preparedData;
            return $this->$property = $preparedData;
        }

        // Handle object response
        if (is_object($modelData) && property_exists($modelData, $property)) {
            static::$model_data = $modelData;
            return $this->$property = $modelData->$property;
        }

        return null;
    }

    /**
     * Get property value from regular request
     *
     * @param string $property Property name
     * @return mixed Property value or null
     */
    protected function getPropertyFromRequest($property)
    {
        $id = $this->extractIdFromRequest();

        if (empty($id)) {
            return null;
        }

        // Use cached model data if ID matches
        if (static::$model_data && static::$model_data->id == $id) {
            return $this->getPropertyFromModel(static::$model_data, $property);
        }

        // Load fresh model data
        $modelData = app(static::$model)::find($id);

        if (empty($modelData)) {
            return null;
        }

        static::$model_data = $modelData;

        return $this->getPropertyFromModel($modelData, $property);
    }

    /**
     * Get property from model instance
     *
     * @param \Illuminate\Database\Eloquent\Model $modelData Model instance
     * @param string $property Property name
     * @return mixed Property value or null
     */
    protected function getPropertyFromModel($modelData, $property)
    {
        $modelArray = $modelData->toArray();

        // Check if property exists directly
        if (array_key_exists($property, $modelArray)) {
            $this->{$property} = $modelArray[$property];
            return $this->{$property};
        }

        // Check if it's a relationship
        if (method_exists($modelData, $property)) {
            $relationshipData = $modelData->$property;
            $this->{$property} = $relationshipData;
            return $this->{$property};
        }

        return null;
    }

    /**
     * Extract record ID from request
     *
     * Checks URL segments 4 and 5 for numeric ID.
     *
     * @return int|null Record ID or null
     */
    protected function extractIdFromRequest()
    {
        if (is_numeric(request()->segment(4))) {
            return (int) request()->segment(4);
        }

        if (is_numeric(request()->segment(5))) {
            return (int) request()->segment(5);
        }

        return null;
    }

    /**
     * Magic call for dynamic method calls
     *
     * Delegates method calls to the loaded model instance.
     *
     * @param string $methodName Method name
     * @param array $args Method arguments
     * @return mixed Method result or null
     */
    public function __call($methodName, $args)
    {
        // Load model data if not already loaded
        if (empty(static::$model_data)) {
            $this->loadModelData();
        }

        // Check if method exists on model
        if (!empty(static::$model_data) && method_exists(static::$model_data, $methodName)) {
            return static::$model_data->$methodName(...$args);
        }

        return null;
    }

    /**
     * Magic static call for dynamic static method calls
     *
     * Delegates static method calls to the loaded model instance.
     *
     * @param string $methodName Method name
     * @param array $args Method arguments
     * @return mixed Method result or null
     */
    public static function __callStatic($methodName, $args)
    {
        if (!empty(static::$model_data) && method_exists(static::$model_data, $methodName)) {
            return static::$model_data->$methodName(...$args);
        }

        return null;
    }

    /**
     * Load model data from request
     *
     * Attempts to load model data from URL segment.
     *
     * @return void
     */
    protected function loadModelData()
    {
        $id = $this->extractIdFromRequest();

        if (empty($id)) {
            return;
        }

        $modelData = app(static::$model)::find($id);

        if (!empty($modelData)) {
            static::$model_data = $modelData;
        }
    }

    /**
     * Get cached model data
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function getModelData()
    {
        return static::$model_data;
    }

    /**
     * Clear cached model data
     *
     * @return void
     */
    public static function clearModelData()
    {
        static::$model_data = null;
    }
}
