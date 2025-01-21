<?php

namespace Dash;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Dash\Extras\Resources\ExecBlankPages;
use Dash\Extras\Resources\ExecResources;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;

class DashRouteServiceProvider extends ServiceProvider
{
    public $loadInNavigationMenu;
    public $loadInNavigationPagesMenu;
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


    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
        app()->setLocale(request('lang', config('dash.DEFAULT_LANG')));

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

        $this->loadInNavigationMenu = (new ExecResources)->loadNavigation();
        $this->loadInNavigationPagesMenu = (new ExecBlankPages)->loadNavigation();

        $dash_guard = config('auth.guards');
        $dash_guard = array_merge($this->guard, $dash_guard);
        Config::set('auth.guards', $dash_guard);

        $local     = $this->locale_path ?? __DIR__ . '/resources/lang';
        //$datatable = $this->datatable_path ?? __DIR__ . '/resources/lang';
        Lang::addNamespace('dash', $local);

        $path = $this->theme_path ?? __DIR__ . '/resources/views';
        View::addNamespace('dash', $path);

        View::composer('*', function ($view) {
            $datatable_content = json_decode(file_get_contents($this->datatable_path . '/datatable/' . app()->getLocale() . '.json'), true);
            $view->with('APP_NAME', $this->APP_NAME ?? env('APP_NAME', ''))
                ->with('datatable_language', $datatable_content)
                ->with('dash_notifications', app('dash')['notifications'])
                ->with('loadInNavigationMenu', $this->loadInNavigationMenu)
                ->with('loadInNavigationPagesMenu', $this->loadInNavigationPagesMenu)
                ->with('DASHBOARD_LANGUAGES', $this->DASHBOARD_LANGUAGES)
                ->with('DASHBOARD_PATH', $this->DASHBOARD_PATH)
                ->with('DASHBOARD_ICON', $this->DASHBOARD_ICON);
        });
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {

        if (config('dash.tenancy.tenancy_mode', 'off') == 'on') {
            foreach (config('tenancy.central_domains', []) as $domain) {
                Route::prefix(config('dash.DASHBOARD_PATH'))
                    ->domain($domain)
                    ->middleware(['web', \Dash\Middleware\SetLocale::class])
                    ->namespace('Controllers')
                    ->group($this->route_path ?? __DIR__ . '/routes/routelist.php');

                if (!empty(tenant('id'))) {
                    Route::prefix(config('dash.DASHBOARD_PATH'))
                        ->domain($domain)
                        ->middleware(['web', \Dash\Middleware\SetLocale::class])
                        ->group(function () {
                            (new ExecResources)->execute();
                            (new ExecBlankPages)->execute();
                        });
                }
            }
        }

        Route::prefix(config('dash.DASHBOARD_PATH'))
            ->middleware(['web', \Dash\Middleware\SetLocale::class])
            ->namespace('Controllers')
            ->group($this->route_path ?? __DIR__ . '/routes/routelist.php');

        Route::prefix(config('dash.DASHBOARD_PATH'))
            ->middleware(['web', \Dash\Middleware\SetLocale::class])
            ->group(function () {
                sleep(2);
                (new ExecResources)->execute();
                (new ExecBlankPages)->execute();
            });
    }
}
