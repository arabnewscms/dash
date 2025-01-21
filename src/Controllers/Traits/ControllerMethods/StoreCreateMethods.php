<?php
namespace Dash\Controllers\Traits\ControllerMethods;
use Dash\RenderableElements\Element;

trait StoreCreateMethods {

	/**
	 * create method to render Elements And relationship from resource
	 * @return view renderable
	 */
	public function create() {

		$admin    = auth()->guard('dash')->user();
		$elements = (new Element($this->fields(), app($this->resource['model']), 'create'))->render();


        $create = request()->ajax() && request('create_with_inline')?'create_inline':'create';
        $view =  view('dash::resource.create.'.$create, [
				'resource'          => $this->resource,
				'resourceName'      => $this->resource['resourceName'],
				'title'             => $this->title.' / '.__('dash::dash.add_new'),
				'relationTypes'     => $this->relationTypes,
				'relationManyTypes' => $this->relationManyTypes,
				'relationOneTypes'  => $this->relationOneTypes,
				'pagesRules'        => $this->pagesRules($admin),
				'fields'            => $elements,
				'filters'           => $this->prepare_filters(),
				'actions'           => $this->prepare_actions(),
				'breadcrumb'        => $this->bread(),
			]);
        return request()->ajax() && request('create_with_inline')? $view->render():$view;
	}

	public function store() {

		$rules    = [];
		$nicename = [];
		foreach ($this->loadField() as $field) {
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

		$model = new $this->resource['model'];


		$model = $this->beforeStore($model);
		// dropzone
		// rename or move files from tempfile Folder after Add record
		if (request("dz_type") == "create") {
			$this->rename(strval($this->resource['model']), request("dz_id"), $model->id);
		}

		// after store data
		$this->afterStore($model);

		if (request()->ajax()) {
			return response([
                    // 'previous'=>url()->previous(),
                    // 'relationField'=> [request('relationField')??'',count(request('relationField',[]))],
					'message' => __('dash::dash.added'),
					'status'  => true,
					'id'      => $model->id,
				], 200);
		} else {
			session()->flash('success', __('dash::dash.added'));
			$url = url(app('dash')['DASHBOARD_PATH'].'/resource/'.$this->resource['resourceName']);
			if (request('add') == 'add') {
				return redirect($url);
			} elseif (request('save') == 'add_again') {
				return redirect($url.'/new');
			} else {
				return back();
			}
		}
	}

}
