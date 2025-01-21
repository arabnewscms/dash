<?php

namespace Dash\Controllers;

use App\Http\Controllers\Controller;
use Dash\Controllers\Traits\ControllerMethods\ActionsMethods;
use Dash\Controllers\Traits\ControllerMethods\DestroyMethods;
use Dash\Controllers\Traits\ControllerMethods\DropzoneMethods;
use Dash\Controllers\Traits\ControllerMethods\EditUpdateMethods;
use Dash\Controllers\Traits\ControllerMethods\FiltersMethods;
use Dash\Controllers\Traits\ControllerMethods\IndexShowMethods;
use Dash\Controllers\Traits\ControllerMethods\LoadSubResourceRelations;
use Dash\Controllers\Traits\ControllerMethods\PolicyMethods;
use Dash\Controllers\Traits\ControllerMethods\PrepareFieldToStoreAndUpdateWithRules;
use Dash\Controllers\Traits\ControllerMethods\RestoreMethods;
use Dash\Controllers\Traits\ControllerMethods\StoreCreateMethods;
use Dash\Controllers\Traits\Supplements\BreadCrumbs;
use Dash\Controllers\Traits\Supplements\DatatableResource;
use Dash\Controllers\Traits\Supplements\FetchInputs;
use Dash\Extras\Inputs\InputOptions\relationTypes;

class LoadResource extends Controller
{
    use
        DatatableResource,
        DestroyMethods,
        PrepareFieldToStoreAndUpdateWithRules,
        RestoreMethods,
        StoreCreateMethods,
        DropzoneMethods,
        IndexShowMethods,
        PolicyMethods,
        EditUpdateMethods,
        ActionsMethods,
        FiltersMethods,
        BreadCrumbs,
        FetchInputs,
        relationTypes,
        LoadSubResourceRelations;

    public $admin;
    public $search;
    public $searchWithRelation;
    public $resource;
    public $title;
    public function __construct($resource)
    {
        $this->search             = $resource['search'];
        $this->searchWithRelation = $resource['searchWithRelation'];
        $this->resource           = $resource;
        $this->title              = $this->resource['navigation']['customName'];
        $this->definePolicy($resource['policy']);
    }

    /**
     * protected custom breadcrumb method to share for storeMethod
     * @param $link string
     * @param $name string
     * @return array
     */
    protected function bread($link = 'new', $name = null)
    {
        $name = $name ?? __('dash::dash.add_new');
        return $this->breadcrumb([
            'name' => $name,
            'url'  => url(app('dash')['DASHBOARD_PATH'] . '/resource/' . $this->resource['resourceName'] . '/' . $link),
        ]);
    }

    /**
     * replace symbols from string path if not clouser
     * @param Object $model
     * @param string $path
     * @return string $path
     */
    public function replaceColumns($model, $string)
    {
        $data = preg_match_all('/{(.*?)}/', $string, $match);
        if (!empty($match[1])) {
            foreach ($match[1] as $match) {
                $string = str_replace('{' . $match . '}', $model->{$match}, $string);
            }
        }
        return $string;
    }
}
