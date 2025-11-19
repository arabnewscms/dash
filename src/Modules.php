<?php

namespace Dash;

// use Illuminate\Filesystem\Filesystem;

/**
 * Modules Trait
 *
 * Provides support for nwidart/laravel-modules package integration.
 * Handles automatic loading and bootstrapping of module service providers
 * for both version 9.x and version 10.x+ of the laravel-modules package.
 *
 * @package Dash
 */
trait Modules
{
    /**
     * Initialize module service provider
     *
     * Detects the module from the current class namespace and attempts
     * to load its service provider for both v9 and v10+ module structures.
     * Automatically registers config, translations, and views if available.
     *
     * @return void
     */
    public function initModule()
    {
        $resource = resourceShortName(get_class($this));
        $explodeClass = explode('\\', get_class($this));

        // Try loading module with v9 structure (Modules\{Module}\Providers)
        $this->_v9($explodeClass, $resource);

        // Try loading module with v10+ structure (Modules\{Module}\app\Providers)
        $this->_v10($explodeClass, $resource);
    }

    /**
     * Load module service provider for Laravel Modules v10+
     *
     * Attempts to load and bootstrap the module's service provider
     * using the v10+ directory structure: Modules\{Module}\app\Providers
     *
     * If the service provider has a boot() method, it will be called.
     * Otherwise, individual registration methods will be called if they exist:
     * - registerConfig()
     * - registerTranslations()
     * - loadTranslationsFrom()
     * - loadJsonTranslationsFrom()
     * - registerViews()
     *
     * @param array $explode_class The exploded class namespace parts
     * @param string $resource The resource short name
     * @return void
     */
    public function _v10($explode_class, $resource)
    {
        // Determine module name from namespace or resource name
        if (!empty($explode_class[1])) {
            $module = '\Modules\\' . $explode_class[1] . '\\app\\Providers\\' . $explode_class[1] . 'ServiceProvider';
        } else {
            $module = '\Modules\\' . $resource . '\\app\\Providers\\' . $resource . 'ServiceProvider';
        }

        // Check if module service provider exists
        if (!class_exists($module)) {
            return;
        }

        // Instantiate the module service provider
        $providerResourceModule = new $module(app());

        // If boot method exists, call it and return
        if (method_exists($module, 'boot')) {
            $providerResourceModule->boot();
            return;
        }

        // Otherwise, manually call individual registration methods
        $this->registerModuleMethods($module, $providerResourceModule);
    }

    /**
     * Load module service provider for Laravel Modules v9
     *
     * Attempts to load and bootstrap the module's service provider
     * using the v9 directory structure: Modules\{Module}\Providers
     *
     * If the service provider has a boot() method, it will be called.
     * Otherwise, individual registration methods will be called if they exist:
     * - registerConfig()
     * - registerTranslations()
     * - loadTranslationsFrom()
     * - loadJsonTranslationsFrom()
     * - registerViews()
     *
     * @param array $explode_class The exploded class namespace parts
     * @param string $resource The resource short name
     * @return void
     */
    public function _v9($explode_class, $resource)
    {
        // Determine module name from namespace or resource name
        if (!empty($explode_class[1])) {
            $module = '\Modules\\' . $explode_class[1] . '\\Providers\\' . $explode_class[1] . 'ServiceProvider';
        } else {
            $module = '\Modules\\' . $resource . '\\Providers\\' . $resource . 'ServiceProvider';
        }

        // Check if module service provider exists
        if (!class_exists($module)) {
            return;
        }

        // Instantiate the module service provider
        $providerResourceModule = new $module(app());

        // If boot method exists, call it and return
        if (method_exists($module, 'boot')) {
            $providerResourceModule->boot();
            return;
        }

        // Otherwise, manually call individual registration methods
        $this->registerModuleMethods($module, $providerResourceModule);
    }

    /**
     * Register individual module methods
     *
     * Calls individual registration methods on the module service provider
     * if they exist. This is used when the provider doesn't have a boot() method.
     *
     * Methods checked and called:
     * - registerConfig() - Registers module configuration files
     * - registerTranslations() - Registers module translation files
     * - loadTranslationsFrom() - Loads translations from specific path
     * - loadJsonTranslationsFrom() - Loads JSON translations
     * - registerViews() - Registers module view files
     *
     * @param string $module The module service provider class name
     * @param object $providerResourceModule The instantiated service provider
     * @return void
     */
    protected function registerModuleMethods($module, $providerResourceModule)
    {
        if (method_exists($module, 'registerConfig')) {
            $providerResourceModule->registerConfig();
        }

        if (method_exists($module, 'registerTranslations')) {
            $providerResourceModule->registerTranslations();
        }

        if (method_exists($module, 'loadTranslationsFrom')) {
            $providerResourceModule->loadTranslationsFrom();
        }

        if (method_exists($module, 'loadJsonTranslationsFrom')) {
            $providerResourceModule->loadJsonTranslationsFrom();
        }

        if (method_exists($module, 'registerViews')) {
            $providerResourceModule->registerViews();
        }
    }
}
