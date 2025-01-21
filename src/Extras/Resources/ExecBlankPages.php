<?php
namespace Dash\Extras\Resources;
use Illuminate\Support\Facades\Route;

class ExecBlankPages
{
    public $registerInNavigationPageMenu = [];
    public $registerPages;

    public function loadNavigation()
    {
        $registerPages = [];
        foreach (app('dash')['blankPages'] as $pageObject) {
            $shortName = resourceShortName($pageObject);

            $registerPages[$pageObject::$position][] = [
                'RouteName' => $shortName,
                'pageNameFull' => get_class(new $pageObject),
                'icon' => $pageObject::$icon,
                'displayInMenu' => $pageObject::$displayInMenu,
                'pageName' => $pageObject::pageName(),
            ];
        }
        return $registerPages;
    }

    // exec resources
    public function execute()
    {
        foreach (app('dash')['blankPages'] as $pageObject) {
            $shortName = resourceShortName($pageObject);

            $navigation = [
                'RouteName' => $shortName,
                'pageNameFull' => get_class(new $pageObject),
                'icon' => $pageObject::$icon,
                'displayInMenu' => $pageObject::$displayInMenu,
                'pageName' => $pageObject::pageName(),
            ];

            // Append The Resources Menu In Navigation property
            $this->registerInNavigationPageMenu[$pageObject::$position][] = $navigation;

            // run if call resource
            if (request()->segment(2) == 'page' && $shortName == request()->segment(3)) {
                $page = new $pageObject;

                // Register page Everythings
                $PageData = [
                    'RouteName' => $shortName,
                    'save' => $page,
                    'model' => $page::$model,
                    'content' => $page::content(),
                    'registerInNavigationPageMenu' => $navigation,
                ];

                $this->registerPages[] = $PageData;
                // register routres
                $this->registerRoutesAndPages($PageData);
                // Init Dynamic Property

            }
        }
    }

    public function registerRoutesAndPages($PageData)
    {
        Route::get('/page/' . $PageData['RouteName'], function () use ($PageData) {
            return $PageData['content'];
        });

        Route::post('/page/' . $PageData['RouteName'] . '/{id}', function ($id) use ($PageData) {
            return $PageData['save']::save($id);
        });
    }
}
