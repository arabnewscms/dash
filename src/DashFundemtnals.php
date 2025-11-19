<?php

namespace Dash;

use Dash\Extras\Resources\ExecBlankPages;
use Dash\Extras\Resources\ExecResources;
use Dash\Middleware\DashAuth;
use Dash\Middleware\DashGuest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;

trait DashFundemtnals
{
    /**
     * Items to load in navigation menu
     *
     * @var mixed
     */
    public $loadInNavigationMenu;

    /**
     * Items to load in navigation pages menu
     *
     * @var mixed
     */
    public $loadInNavigationPagesMenu;

    /**
     * Add or append views path to the application
     *
     * Registers a namespace for Dash views, allowing the application
     * to locate and render views from the specified theme path.
     *
     * @return $this
     */
    public function appendViews()
    {
        $path = $this->theme_path ?? __DIR__ . '/resources/views';
        View::addNamespace('dash', $path);

        return $this;
    }

    /**
     * Execute and register resources
     *
     * Initializes the resources execution process and registers
     * items that should appear in the navigation menu.
     *
     * @return $this
     */
    public function executeResources()
    {
        $resources = new ExecResources();
        $resources->execute();
        $this->loadInNavigationMenu = $resources->registerInNavigationMenu;

        return $this;
    }

    /**
     * Execute custom pages
     *
     * Initializes the custom blank pages execution process and registers
     * items that should appear in the navigation page menu.
     *
     * @return $this
     */
    public function executePages()
    {
        $pages = new ExecBlankPages();
        $pages->execute();

        $this->loadInNavigationPagesMenu = $pages->registerInNavigationPageMenu;

        return $this;
    }

    /**
     * Add or append localization path
     *
     * Registers language namespaces for both general localization
     * and datatable specific translations.
     *
     * @return $this
     */
    public function localization()
    {
        $local = $this->locale_path ?? __DIR__ . '/resources/lang';
        $datatable = $this->datatable_path ?? __DIR__ . '/resources/lang';
        Lang::addNamespace('dash', $local);

        return $this;
    }

    /**
     * Add or append guard configuration
     *
     * Merges custom dashboard guard configuration with the existing
     * authentication guards in the application.
     *
     * @return $this
     */
    public function appendGuard()
    {
        $dashGuard = config('auth.guards');
        $dashGuard = array_merge($this->guard, $dashGuard);
        Config::set('auth.guards', $dashGuard);

        return $this;
    }

    /**
     * Register dashboard routes
     *
     * Loads and registers all dashboard routes with the specified
     * prefix, middleware, and namespace configuration.
     *
     * @return $this
     */
    public function routes()
    {
        $routeLists = $this->route_path ?? __DIR__ . '/routes/routelist.php';

        Route::prefix($this->DASHBOARD_PATH)
            ->middleware('web')
            ->namespace('Controllers')
            ->group($routeLists);

        return $this;
    }

    /**
     * Register authentication middleware
     *
     * Aliases the dashboard authentication and guest middleware
     * for use in route definitions.
     *
     * @return $this
     */
    public function middlewareWithAuthentication()
    {
        app()['router']->aliasMiddleware('dash.auth', DashAuth::class);
        app()['router']->aliasMiddleware('dash.guest', DashGuest::class);

        return $this;
    }

    /**
     * Register view composer
     *
     * Shares common dashboard data with all views including app name,
     * datatable language settings, notifications, navigation menus,
     * and dashboard configuration.
     *
     * @return $this
     */
    public function viewComposer()
    {
        View::composer('*', function ($view) {
            $datatableContent = json_decode(
                file_get_contents($this->datatable_path . '/' . app()->getLocale() . '/datatable.json'),
                true
            );

            $view->with('APP_NAME', $this->APP_NAME ?? env('APP_NAME', ''))
                ->with('datatable_language', $datatableContent)
                ->with('dash_notifications', app('dash')['notifications'])
                ->with('loadInNavigationMenu', $this->loadInNavigationMenu)
                ->with('loadInNavigationPagesMenu', $this->loadInNavigationPagesMenu)
                ->with('DASHBOARD_LANGUAGES', $this->DASHBOARD_LANGUAGES)
                ->with('DASHBOARD_PATH', $this->DASHBOARD_PATH)
                ->with('DASHBOARD_ICON', $this->DASHBOARD_ICON);
        });

        return $this;
    }
}
