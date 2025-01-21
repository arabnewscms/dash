<?php

namespace Dash;

use Dash\DashFundemtnals;
use Illuminate\Support\ServiceProvider;


class DashServiceProviderInit extends ServiceProvider
{

    // reference dashboard
    protected $theme_path;
    protected $locale_path;
    protected $datatable_path;
    protected $route_path;
    protected $guard;

    protected $DEFAULT_LANG;
    protected $DASHBOARD_LANGUAGES;
    protected $DASHBOARD_PATH;
    protected $APP_NAME;
    protected $DASHBOARD_ICON;

    public function __construct()
    {

        $this->theme_path     = config('dash.THEME_PATH');
        $this->locale_path    = config('dash.LOCALE_PATH');
        $this->datatable_path = config('dash.DATATABLE_LOCALE_PATH');
        $this->route_path     = config('dash.ROUTE_PATH');
        $this->guard          = config('dash.GUARD');
        $this->DASHBOARD_PATH      = config('dash.DASHBOARD_PATH');
        $this->DEFAULT_LANG        = config('dash.DEFAULT_LANG');
        $this->DASHBOARD_LANGUAGES = config('dash.DASHBOARD_LANGUAGES');
        $this->DASHBOARD_ICON      = config('dash.DASHBOARD_ICON');
        $this->APP_NAME            = config('dash.APP_NAME');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app()->register(DashRouteServiceProvider::class);
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
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {


        // Set Locale By Cache
        // app()->setLocale(cache('DASHBOARD_CURRENT_LANG', config('dash.DEFAULT_LANG')));

    }
}
