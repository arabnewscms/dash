<?php
namespace Dash;

use Illuminate\Filesystem\Filesystem;

trait Modules
{

    // check if nwidart/laravel-modules installed
    public function initModule()
    {
        $resource = resourceShortName(get_class($this));
        $explode_class = explode('\\', get_class($this));

        $this->_v9($explode_class, $resource);
        $this->_v10($explode_class, $resource);
    }


    public function _v10($explode_class, $resource)
    {
        if(!empty($explode_class[1])) {
            $module   = '\Modules\\'.$explode_class[1].'\\app\\Providers\\'.$explode_class[1].'ServiceProvider';
        } else {
            $module   = '\Modules\\'.$resource.'\\app\\Providers\\'.$resource.'ServiceProvider';
        }

        if (class_exists($module)) {
            $providerResourceModule = new $module(app());
            if (method_exists($module, 'boot')) {
                $providerResourceModule->boot();

            } else {

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
    }

    public function _v9($explode_class, $resource)
    {
        if(!empty($explode_class[1])) {
            $module   = '\Modules\\'.$explode_class[1].'\\Providers\\'.$explode_class[1].'ServiceProvider';
        } else {
            $module   = '\Modules\\'.$resource.'\\Providers\\'.$resource.'ServiceProvider';
        }

        if (class_exists($module)) {
            $providerResourceModule = new $module(app());
            if (method_exists($module, 'boot')) {
                $providerResourceModule->boot();

            } else {

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
    }

}
