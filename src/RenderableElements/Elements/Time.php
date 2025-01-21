<?php
namespace Dash\RenderableElements\Elements;

trait Time {

	public function getTimeElement($field, $model, $page) {
		return $page == 'create'?
		$this->timeCreate($field, $model, $page):
		$this->timeUpdate($field, $model, $page);
	}

	public function timeCreate($field, $model, $page) {
		return view('dash::resource.renderElements.time.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function timeUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.time.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}