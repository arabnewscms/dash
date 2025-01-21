<?php

namespace Dash;

use Dash\Extras\Resources\ExecBlankPages;
use Dash\Extras\Resources\ExecResources;
use Dash\Middleware\DashAuth;
use Dash\Middleware\DashGuest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

trait DashFundemtnals
{
    public $loadInNavigationMenu;
    public $loadInNavigationPagesMenu;

    /**
     *  add or Append views Path
     * @return $this chaining method
     */
    public

    function appendViews()
    {
        $path = $this->theme_path ?? __DIR__ . '/resources/views';
        View::addNamespace('dash', $path);
        return $this;
    }

    public function executeResources()
    {

        $resources = (new ExecResources);
        $resources->execute();
        $this->loadInNavigationMenu = $resources->registerInNavigationMenu;

        return $this;
    }

    /**
     * Execute Custom Pages
     * @return chaining method
     */
    public function executePages()
    {
        $pages = (new ExecBlankPages);
        $pages->execute();

        $this->loadInNavigationPagesMenu = $pages->registerInNavigationPageMenu;
        return $this;
    }

    /**
     *  add or Append local Path
     * @return $this chaining method
     */
    public function localization()
    {
        $local     = $this->locale_path ?? __DIR__ . '/resources/lang';
        $datatable = $this->datatable_path ?? __DIR__ . '/resources/lang';
        \Lang::addNamespace('dash', $local);
        return $this;
    }

    /**
     *  add or Append guard
     * @return $this chaining method
     */
    public function appendGuard()
    {
        $dash_guard = config('auth.guards');
        $dash_guard = array_merge($this->guard, $dash_guard);
        \Config::set('auth.guards', $dash_guard);
        return $this;
    }


    /**
     *  add or Append routes Path
     * @return $this chaining method
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

    public function middlewareWithAuthentication()
    {
        //app()['router']->aliasMiddleware('dash_language', DashLanguage::class);
        app()['router']->aliasMiddleware('dash.auth', DashAuth::class);
        app()['router']->aliasMiddleware('dash.guest', DashGuest::class);
        return $this;
    }

    public function viewComposer()
    {
        \View::composer('*', function ($view) {
            $datatable_content = json_decode(file_get_contents($this->datatable_path . '/' . app()->getLocale() . '/datatable.json'), true);
            $view->with('APP_NAME', $this->APP_NAME ?? env('APP_NAME', ''))
                ->with('datatable_language', $datatable_content)
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
