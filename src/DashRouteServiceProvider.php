<?php

namespace Dash;

use Dash\Extras\Resources\ExecBlankPages;
use Dash\Extras\Resources\ExecResources;
use Dash\Middleware\SetLocale;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class DashRouteServiceProvider extends ServiceProvider
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
     * Theme path for dashboard views
     *
     * @var string|null
     */
    protected $theme_path;

    /**
     * Locale path for translations
     *
     * @var string|null
     */
    protected $locale_path;

    /**
     * Datatable locale path for datatable translations
     *
     * @var string|null
     */
    protected $datatable_path;

    /**
     * Route file path
     *
     * @var string|null
     */
    protected $route_path;

    /**
     * Authentication guard configuration
     *
     * @var array
     */
    protected $guard;

    /**
     * Default language for dashboard
     *
     * @var string
     */
    protected $DEFAULT_LANG;

    /**
     * Available dashboard languages
     *
     * @var array
     */
    protected $DASHBOARD_LANGUAGES;

    /**
     * Dashboard URL path prefix
     *
     * @var string
     */
    protected $DASHBOARD_PATH;

    /**
     * Application name
     *
     * @var string
     */
    protected $APP_NAME;

    /**
     * Dashboard icon
     *
     * @var string
     */
    protected $DASHBOARD_ICON;

    /**
     * Bootstrap the service provider
     *
     * Called before routes are registered. Sets up locale, configuration paths,
     * navigation menus, authentication guards, language namespaces, view paths,
     * and view composers for dashboard functionality.
     *
     * Supports both single and SaaS project modes.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        // Set application locale from request or default config
        app()->setLocale(request('lang', config('dash.DEFAULT_LANG')));

        // Load configuration paths
        $this->loadConfigurationPaths();

        // Initialize navigation menus
        $this->initializeNavigationMenus();

        // Configure authentication guards
        $this->configureAuthenticationGuards();

        // Register language namespaces
        $this->registerLanguageNamespaces();

        // Register view namespaces
        $this->registerViewNamespaces();

        // Register view composers
        $this->registerViewComposers();
    }

    /**
     * Load all configuration paths from config file
     *
     * Initializes theme path, locale paths, route path, guard configuration,
     * and dashboard settings from the dash configuration file.
     *
     * @return void
     */
    protected function loadConfigurationPaths(): void
    {
        $this->theme_path          = config('dash.THEME_PATH');
        $this->locale_path         = config('dash.LOCALE_PATH');
        $this->datatable_path      = config('dash.DATATABLE_LOCALE_PATH');
        $this->route_path          = config('dash.ROUTE_PATH');
        $this->guard               = config('dash.GUARD');
        $this->DASHBOARD_PATH      = config('dash.DASHBOARD_PATH');
        $this->DEFAULT_LANG        = config('dash.DEFAULT_LANG');
        $this->DASHBOARD_LANGUAGES = config('dash.DASHBOARD_LANGUAGES');
        $this->DASHBOARD_ICON      = config('dash.DASHBOARD_ICON');
        $this->APP_NAME            = config('dash.APP_NAME');
    }

    /**
     * Initialize navigation menus for dashboard
     *
     * Loads navigation items for both main resources menu and
     * custom pages menu by executing their respective loaders.
     *
     * @return void
     */
    protected function initializeNavigationMenus(): void
    {
        $this->loadInNavigationMenu      = (new ExecResources())->loadNavigation();
        $this->loadInNavigationPagesMenu = (new ExecBlankPages())->loadNavigation();
    }

    /**
     * Configure authentication guards
     *
     * Merges dashboard-specific authentication guards with the
     * application's existing guard configuration.
     *
     * @return void
     */
    protected function configureAuthenticationGuards(): void
    {
        $dashGuard = config('auth.guards');
        $dashGuard = array_merge($this->guard, $dashGuard);
        Config::set('auth.guards', $dashGuard);
    }

    /**
     * Register language namespaces
     *
     * Adds the 'dash' namespace for language files, allowing dashboard
     * translations to be loaded from the configured locale path.
     *
     * @return void
     */
    protected function registerLanguageNamespaces(): void
    {
        $local = $this->locale_path ?? __DIR__ . '/resources/lang';
        Lang::addNamespace('dash', $local);
    }

    /**
     * Register view namespaces
     *
     * Adds the 'dash' namespace for views, allowing dashboard views
     * to be loaded from the configured theme path.
     *
     * @return void
     */
    protected function registerViewNamespaces(): void
    {
        $path = $this->theme_path ?? __DIR__ . '/resources/views';
        View::addNamespace('dash', $path);
    }

    /**
     * Register view composers for all views
     *
     * Shares common dashboard data with all views including:
     * - Application name
     * - Datatable language settings
     * - Dashboard notifications
     * - Navigation menus (resources and pages)
     * - Dashboard configuration (languages, path, icon)
     *
     * @return void
     */
    protected function registerViewComposers(): void
    {
        View::composer('*', function ($view) {
            $datatableContent = json_decode(
                file_get_contents($this->datatable_path . '/datatable/' . app()->getLocale() . '.json'),
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
    }

    /**
     * Define the routes for the application
     *
     * Entry point for route registration. Delegates to mapWebRoutes
     * to handle actual route definitions.
     *
     * @return void
     */
    public function map(): void
    {
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application
     *
     * Registers all dashboard routes with session state, CSRF protection, etc.
     * Supports both single-tenant and multi-tenant (SaaS) configurations.
     *
     * For tenancy mode:
     * - Routes are registered for each central domain
     * - Additional tenant-specific routes are registered when a tenant is active
     *
     * For standard mode:
     * - Routes are registered with dashboard prefix and middleware
     *
     * @return void
     */
    protected function mapWebRoutes(): void
    {
        // Check if tenancy mode is enabled
        if (config('dash.tenancy.tenancy_mode', 'off') === 'on') {
            $this->registerTenancyRoutes();
        }

        // Register standard dashboard routes
        $this->registerStandardRoutes();
    }

    /**
     * Register routes for multi-tenant (SaaS) mode
     *
     * Registers routes for each central domain with tenancy support.
     * When a tenant is active, additional tenant-specific routes are registered.
     *
     * @return void
     */
    protected function registerTenancyRoutes(): void
    {
        $centralDomains = config('tenancy.central_domains', []);

        foreach ($centralDomains as $domain) {
            // Register central domain routes
            Route::prefix(config('dash.DASHBOARD_PATH'))
                ->domain($domain)
                ->middleware(['web', SetLocale::class])
                ->namespace('Controllers')
                ->group($this->route_path ?? __DIR__ . '/routes/routelist.php');

            // Register tenant-specific routes if tenant is active
            if (!empty(tenant('id'))) {
                Route::prefix(config('dash.DASHBOARD_PATH'))
                    ->domain($domain)
                    ->middleware(['web', SetLocale::class])
                    ->group(function () {
                        (new ExecResources())->execute();
                        (new ExecBlankPages())->execute();
                    });
            }
        }
    }

    /**
     * Register standard dashboard routes
     *
     * Registers dashboard routes for single-tenant mode with:
     * - Dashboard path prefix
     * - Web middleware and locale middleware
     * - Controllers namespace
     * - Resource and page route execution
     *
     * @return void
     */
    protected function registerStandardRoutes(): void
    {
        // Register main route list
        Route::prefix(config('dash.DASHBOARD_PATH'))
            ->middleware(['web', SetLocale::class])
            ->namespace('Controllers')
            ->group($this->route_path ?? __DIR__ . '/routes/routelist.php');

        // Register dynamic resource and page routes
        Route::prefix(config('dash.DASHBOARD_PATH'))
            ->middleware(['web', SetLocale::class])
            ->group(function () {
                (new ExecResources())->execute();
                (new ExecBlankPages())->execute();
            });
    }
}
