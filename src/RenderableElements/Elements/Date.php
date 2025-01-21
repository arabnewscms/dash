<?php
namespace Dash\RenderableElements\Elements;

trait Date {

	public function getDateElement($field, $model, $page) {
		return $page == 'create'?
		$this->dateCreate($field, $model, $page):
		$this->dateUpdate($field, $model, $page);
	}

	public function dateCreate($field, $model, $page) {
		return view('dash::resource.renderElements.date.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function dateUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.date.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}