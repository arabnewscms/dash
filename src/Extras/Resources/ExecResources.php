<?php

namespace Dash\Extras\Resources;

use Dash\Controllers\LoadResource;
use Dash\Extras\Inputs\InputOptions\relationTypes;
//use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class ExecResources
{
    use relationTypes;
    public $registerInNavigationMenu = [];
    public $registerResource = [];

    public function loadNavigation()
    {
        $registerInNavigationMenu = [];
        if (!empty(app('dash')['resources']) && is_array(app('dash')['resources'])) {
            foreach (app('dash')['resources'] as $resources) {
                app()->bind($resources);
                $shortName  = resourceShortName($resources);
                $navigation = [
                    'resourceName'     => $shortName,
                    'resourceNameFull' => get_class(new $resources),
                    'icon'             => $resources::$icon,
                    'group'            => $resources::$group,
                    'displayInMenu'    => $resources::$displayInMenu,
                    'customName'       => $resources::customName(),
                ];

                // Append The Resources Menu In Navigation property
                $group_level = explode('.', $resources::$group);
                if (count($group_level) > 1) {
                    $registerInNavigationMenu[$group_level[0]][$group_level[1]][] = $navigation;
                } else {
                    $registerInNavigationMenu[$group_level[0]][] = $navigation;
                }
            }
        }

        return $registerInNavigationMenu;
    }

    // exec resources
    public function execute()
    {
        if (!empty(app('dash')['resources']) && is_array(app('dash')['resources'])) {
            foreach (app('dash')['resources'] as $resources) {
                app()->bind($resources);
                $shortName  = resourceShortName($resources);
                $navigation = [
                    'resourceName'     => $shortName,
                    'resourceNameFull' => get_class(new $resources),
                    'icon'             => $resources::$icon,
                    'group'            => $resources::$group,
                    'displayInMenu'    => $resources::$displayInMenu,
                    'customName'       => $resources::customName(),
                ];

                // Append The Resources Menu In Navigation property

                // run if call resource
                if (request()->segment(2) == 'resource' && $shortName == request()->segment(3)) {
                    $resource = new $resources;
                    // Register Resource Everythings
                    $resourceData = [
                        'resourceName'     => $shortName,
                        'resourceNameFull' => get_class($resource),
                        'model'            => $resource::$model,
                        'policy'           => $resource::$policy,
                        //'query'            => $resource->query(app($resource::$model)),
                        'fields'  => $resource->fields(),
                        'actions' => $resource->actions(),
                        'filters' => $resource->filters(),
                        'title'   => $resource::$title,
                        'search'  => $resource::$search,

                        'searchWithRelation' => $resource::$searchWithRelation,
                        //'pagesRules'               => $resource->pagesRules(),
                        'registerInNavigationMenu' => $this->registerInNavigationMenu,
                        'navigation' => $navigation,
                        // datatable
                        'lengthMenu'        => $resource::$lengthMenu,
                        'lengthChange'      => $resource::$lengthChange,
                        'paging'            => $resource::$paging,
                        'pagingType'        => $resource::$pagingType,
                        'ordering'          => $resource::$ordering,
                        'processing'        => $resource::$processing,
                        'serverSide'        => $resource::$serverSide,
                        'scrollY'           => $resource::$scrollY,
                        'scrollX'           => $resource::$scrollX,
                        'scrollCollapse'    => $resource::$scrollCollapse,
                        'multiSelectRecord' => $resource::$multiSelectRecord,
                        'searching'         => $resource::$searching,
                        'dtButtons'         => $resource::dtButtons(),
                    ];
                    $this->registerResource[] = $resourceData;
                    $this->map($resourceData);
                }
            }
        }


    }

    public function map($resourceData)
    {
        $LoadResource = new LoadResource($resourceData);
        // Index
        Route::get('/resource/' . $resourceData['resourceName'], function () use ($LoadResource, $resourceData) {
            return !$LoadResource->pagesRules(auth()->guard('dash')->user())['index'] ?
                redirect(app('dash')['DASHBOARD_PATH'] . '/no-permission') :
                $LoadResource->index();
        });

        // Index datatable
        Route::post('/resource/' . $resourceData['resourceName'] . '/datatable', function () use ($LoadResource, $resourceData) {
            return !$LoadResource->pagesRules(auth()->guard('dash')->user())['index'] ?
                redirect(app('dash')['DASHBOARD_PATH'] . '/no-permission') :
                $LoadResource->datatable();
        });

        // sub resource datatable
        Route::post('/resource/' . $resourceData['resourceName'] . '/sub/datatable', function () use ($LoadResource, $resourceData) {
            return !$LoadResource->pagesRules(auth()->guard('dash')->user())['index'] ?
                redirect(app('dash')['DASHBOARD_PATH'] . '/no-permission') :
                $LoadResource->SubDatatable();
        });

        // create
        Route::get('/resource/' . $resourceData['resourceName'] . '/new', function () use ($LoadResource, $resourceData) {
            return !$LoadResource->pagesRules(auth()->guard('dash')->user())['create'] ?
                redirect(app('dash')['DASHBOARD_PATH'] . '/no-permission') :
                $LoadResource->create();
        });
        // Store
        Route::post('/resource/' . $resourceData['resourceName'], function () use ($LoadResource, $resourceData) {
            return !$LoadResource->pagesRules(auth()->guard('dash')->user())['store'] ?
                redirect(app('dash')['DASHBOARD_PATH'] . '/no-permission') :
                $LoadResource->store();
        })->middleware([\Dash\Middleware\SetLocale::class]);
        // Show
        Route::get('/resource/' . $resourceData['resourceName'] . '/{id}', function ($id) use ($LoadResource, $resourceData) {
            return !$LoadResource->pagesRules(auth()->guard('dash')->user())['show'] ?
                redirect(app('dash')['DASHBOARD_PATH'] . '/no-permission') :
                $LoadResource->show($id);
        });
        // Edit
        Route::get('/resource/' . $resourceData['resourceName'] . '/edit/{id}', function ($id) use ($LoadResource, $resourceData) {
            return !$LoadResource->pagesRules(auth()->guard('dash')->user())['edit'] ?
                redirect(app('dash')['DASHBOARD_PATH'] . '/no-permission') :
                $LoadResource->edit($id);
        });
        // Update
        Route::put('/resource/' . $resourceData['resourceName'] . '/{id}', function ($id) use ($LoadResource, $resourceData) {
            return !$LoadResource->pagesRules(auth()->guard('dash')->user())['update'] ?
                redirect(app('dash')['DASHBOARD_PATH'] . '/no-permission') :
                $LoadResource->update($id);
        });
        // multi delete
        Route::delete('/resource/' . $resourceData['resourceName'] . '/multi/delete', function () use ($LoadResource, $resourceData) {
            return !$LoadResource->pagesRules(auth()->guard('dash')->user())['destroy'] ?
                redirect(app('dash')['DASHBOARD_PATH'] . '/no-permission') :
                $LoadResource->multi_destroy();
        });
        // delete
        Route::delete('/resource/' . $resourceData['resourceName'] . '/{id}', function ($id) use ($LoadResource, $resourceData) {
            return !$LoadResource->pagesRules(auth()->guard('dash')->user())['destroy'] ?
                redirect(app('dash')['DASHBOARD_PATH'] . '/no-permission') :
                $LoadResource->destroy($id);
        });
        //force delete
        Route::delete('/resource/' . $resourceData['resourceName'] . '/force/{id}', function ($id) use ($LoadResource, $resourceData) {
            return !$LoadResource->pagesRules(auth()->guard('dash')->user())['forceDestroy'] ?
                redirect(app('dash')['DASHBOARD_PATH'] . '/no-permission') :
                $LoadResource->forceDestroy($id);
        });
        //restore
        Route::post('/resource/' . $resourceData['resourceName'] . '/restore/{id}', function ($id) use ($LoadResource, $resourceData) {
            return !$LoadResource->pagesRules(auth()->guard('dash')->user())['restore'] ?
                redirect(app('dash')['DASHBOARD_PATH'] . '/no-permission') :
                $LoadResource->restore($id);
        });
        // multi restore
        Route::post('/resource/' . $resourceData['resourceName'] . '/multi/restore', function () use ($LoadResource, $resourceData) {
            return !$LoadResource->pagesRules(auth()->guard('dash')->user())['restore'] ?
                redirect(app('dash')['DASHBOARD_PATH'] . '/no-permission') :
                $LoadResource->multi_restore();
        });
        // load SubResources
        Route::post('/resource/' . $resourceData['resourceName'] . '/sub/resource', function () use ($LoadResource, $resourceData) {
            return $LoadResource->subResource();
        });
        // exec execAction
        Route::post('/resource/' . $resourceData['resourceName'] . '/action/{id?}', function () use ($LoadResource, $resourceData) {
            return $LoadResource->execAction();
        });
        // dropzone
        Route::post('/resource/' . $resourceData['resourceName'] . '/upload/multi', function () use ($LoadResource, $resourceData) {
            return $LoadResource->multi_upload();
        });

        // dropzone
        Route::post('/resource/' . $resourceData['resourceName'] . '/delete/file', function () use ($LoadResource, $resourceData) {
            return $LoadResource->delete_file();
        });
    }
}
