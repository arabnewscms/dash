<?php
namespace Dash\RenderableElements\Elements;

trait Number {

	public function getNumberElement($field, $model, $page) {
		return $page == 'create'?
		$this->numberCreate($field, $model, $page):
		$this->numberUpdate($field, $model, $page);
	}

	public function numberCreate($field, $model, $page) {
		return view('dash::resource.renderElements.number.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function numberUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.number.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}