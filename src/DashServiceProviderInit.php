<?php

namespace Dash;

use Illuminate\Support\ServiceProvider;

/**
 * Dash Service Provider Initializer
 *
 * Base service provider for initializing the PHPDash package.
 * This class should be extended by the application's DashServiceProvider
 * in App\Providers\DashServiceProvider to register custom dashboards,
 * resources, notifications, and blank pages.
 *
 * @package Dash
 */
class DashServiceProviderInit extends ServiceProvider
{
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
     * Constructor
     *
     * Loads all dashboard configuration values from the config file
     * and initializes protected properties for use throughout the provider.
     */
    public function __construct()
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
     * Register services
     *
     * Registers the dashboard route service provider and creates a singleton
     * for the 'dash' service container binding. This binding provides access to:
     * - Registered dashboards (from child class)
     * - Available resources (from child class)
     * - Dashboard notifications (from child class)
     * - Custom blank pages (from child class)
     * - Dashboard path configuration
     *
     * The static method calls will be resolved from the extending class
     * in the application (App\Providers\DashServiceProvider).
     *
     * @return void
     */
    public function register()
    {
        // Register the route service provider
        app()->register(DashRouteServiceProvider::class);

        // Register the main dash singleton
        // Static methods are resolved from the child class
        app()->singleton('dash', function () {
            return [
                'dashboards'     => static::dashboards(),
                'resources'      => static::resources(),
                'notifications'  => static::notifications(),
                'blankPages'     => static::blankPages(),
                'DASHBOARD_PATH' => $this->DASHBOARD_PATH,
            ];
        });
    }

    /**
     * Bootstrap services
     *
     * Performs any necessary bootstrapping for the dashboard.
     * Currently reserved for future initialization tasks.
     *
     * Note: Locale setting is handled in DashRouteServiceProvider::boot()
     * to ensure proper request context.
     *
     * @return void
     */
    public function boot()
    {
        // Locale setting is handled in DashRouteServiceProvider
        // app()->setLocale(cache('DASHBOARD_CURRENT_LANG', config('dash.DEFAULT_LANG')));
    }
}
