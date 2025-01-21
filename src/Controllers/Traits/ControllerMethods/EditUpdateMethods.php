<?php
namespace Dash\Controllers\Traits\ControllerMethods;
use Dash\RenderableElements\Element;

trait EditUpdateMethods {

	/**
	 * create method to render Elements And relationship from resource
	 * @return view renderable
	 */
	public function edit($id) {

		$admin = auth()->guard('dash')->user();
		$edit  = app($this->resource['model'])::findOrFail($id);
		$title = __('dash::dash.edit').' : '.$edit->{ $this->resource['title']}??__('dash::dash.edit');

		$elements = (new Element($this->fields(), $edit, 'edit'))->render();
        $edit_blade = request()->ajax() && request('edit_with_inline')?'edit_inline':'edit';
        $view =  view('dash::resource.edit.'.$edit_blade, [
            'resource'          => $this->resource,
            'resourceName'      => $this->resource['resourceName'],
            'title'             => $this->title.' / '.$title,
            'relationTypes'     => $this->relationTypes,
            'relationManyTypes' => $this->relationManyTypes,
            'relationOneTypes'  => $this->relationOneTypes,
            'model'             => $edit,
            'pagesRules'        => $this->pagesRules($admin),
            'fields'            => $elements,
            'filters'           => $this->prepare_filters(),
            'actions'           => $this->prepare_actions(),
            'breadcrumb'        => $this->bread('edit/'.$id, __('dash::dash.edit')),
            ]);

            return request()->ajax() && request('edit_with_inline')? $view->render():$view;
	}

	public function update($id) {
		$rules    = [];
		$nicename = [];
		foreach ($this->loadField('edit') as $field) {
			if (!empty($field['rules'])) {
				if (isset($field['translatable']) && !empty($field['translatable']) && count($field['translatable']) > 0) {
					foreach ($field['translatable'] as $key => $value) {
						$inputName            = $key.'.'.$field['attribute'];
						$rules[$inputName]    = $field['rules'];
						$nicename[$inputName] = $field['nicename'].' - '.$value;
					}
				} else {
					$rules[$field['attribute']]    = $field['rules'];
					$nicename[$field['attribute']] = $field['nicename'];
				}
			}
		}

		// Validate Requests
		$this->validate(request(), $rules, [], $nicename);
		$model = app($this->resource['model'])::find($id);
		$model = $this->beforeUpdate($model);
		// save without file uploads
		//$model->save();

		$model = $this->afterUpdate($model);
		// save with file uploads
		$model->save();
		if (request()->ajax()) {
			return response([
					'message' => __('dash::dash.updated'),
					'status'  => true,
					'id'      => $model->id,
				], 200);
		} else {

			session()->flash('success', __('dash::dash.updated'));
			$url = url(app('dash')['DASHBOARD_PATH'].'/resource/'.$this->resource['resourceName']);
			if (request('save') == 'edit') {
				return redirect($url);
			} elseif (request('save') == 'edit_again') {
				return redirect($url.'/edit/'.$id);
			} else {
				return back();
			}
		}
	}

}
