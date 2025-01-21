<?php

namespace Dash\Controllers\Traits\ControllerMethods;

use Dash\RenderableElements\Element;

trait IndexShowMethods
{

    public function index()
    {

        $admin = auth()->guard('dash')->user();
        $inputShowinFilter = [];
        $disabled_inputs  = [
            'text',
            'textarea',
            'file',
            'image',
            'dropzone',
            'ckeditor',
            'hasManyThrough',
            'hasMany',
            'belongsToMany',
            'morphToMany',
            'morphedByMany',
            'morphMany',
            'audio',
            'video',
            'morphTo'
        ];

        foreach ($this->fields() as $field) {
            if (isset($field['addToFilter']) && $field['addToFilter'] == true && !in_array($field['type'], $disabled_inputs)) {
                $inputShowinFilter[] = $field;
            }
        }
        // this filter show in index with datatable
        $filterHtmlElements = (new Element($inputShowinFilter, app($this->resource['model']), 'create'))->render();

        return view('dash::resource.index', [
            'resource'          => $this->resource,
            'resourceName'      => $this->resource['resourceName'],
            'title'             => $this->title,
            'relationTypes'     => $this->relationTypes,
            'relationManyTypes' => $this->relationManyTypes,
            'relationOneTypes'  => $this->relationOneTypes,
            'pagesRules'        => $this->pagesRules($admin),
            'fields'            => $this->fields(),
            // for filter in datatable
            'filterHtmlElements'            => $filterHtmlElements,
            'filterTextElements'            => $inputShowinFilter,
            'filters'           => $this->prepare_filters(),
            'actions'           => $this->prepare_actions(),
            'breadcrumb'        => $this->breadcrumb(),
            //datatable
            'multiSelectRecord' => $this->resource['multiSelectRecord'],
            'lengthMenu'        => $this->resource['lengthMenu'],
            'lengthChange'      => $this->resource['lengthChange'],
            'paging'            => $this->resource['paging'],
            'pagingType'        => $this->resource['pagingType'],
            'ordering'          => $this->resource['ordering'],
            'processing'        => $this->resource['processing'],
            'serverSide'        => $this->resource['serverSide'],
            'scrollY'           => $this->resource['scrollY'],
            'scrollX'           => $this->resource['scrollX'],
            'scrollCollapse'    => $this->resource['scrollCollapse'],
            'searching'         => $this->resource['searching'],
            'dtButtons'         => $this->resource['dtButtons'],
        ]);
    }

    public function show($id)
    {
        $admin = auth()->guard('dash')->user();
        $data  = app($this->resource['model'])::findOrFail($id);
        if (empty($data)) {
            session()->flash('error', __('dash::dash.record_not_found'));
            return redirect(app('dash')['DASHBOARD_PATH'] . '/resource/' . $this->resource['resourceName']);
        }
        $title      = __('dash::dash.show') . ' : ' . $data->{$this->resource['title']} ?? '-';
        $breadcrumb = [
            'name' => $title,
            'url'  => url(app('dash')['DASHBOARD_PATH'] . '/resource/' . $this->resource['resourceName'] . '/' . $id),
        ];
        $show_blade = request()->ajax() && request('show_with_inline') ? 'show_inline' : 'show';
        $view = view('dash::resource.show.' . $show_blade, [
            'data'              => $data,
            'fields'            => $this->fields(),
            //'filters'           => $this->prepare_filters(),
            'actions'           => $this->prepare_actions(),
            'breadcrumb'        => $this->breadcrumb($breadcrumb),
            'title'             => $title,
            'resource'          => $this->resource,
            'resourceName'      => $this->resource['resourceName'],
            'pagesRules'        => $this->pagesRules($admin),
            'relationTypes'     => $this->relationTypes,
            'relationManyTypes' => $this->relationManyTypes,
            'relationOneTypes'  => $this->relationOneTypes,
            'model'             => $this->resource['model'],
            'record_id'         => $id,
        ]);
        return request()->ajax() && request('edit_with_inline') ? $view->render() : $view;
    }
}
