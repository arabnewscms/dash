<?php
namespace Dash\RenderableElements\Elements;

trait DateTimeElm {

	public function getDateTimeElement($field, $model, $page) {
		return $page == 'create'?
		$this->datetimeCreate($field, $model, $page):
		$this->datetimeUpdate($field, $model, $page);
	}

	public function datetimeCreate($field, $model, $page) {
		return view('dash::resource.renderElements.datetime.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function datetimeUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.datetime.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}