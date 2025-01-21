<?php
namespace Dash\RenderableElements\Elements;

trait Tel {

	public function getTelElement($field, $model, $page) {
		return $page == 'create'?
		$this->telCreate($field, $model, $page):
		$this->telUpdate($field, $model, $page);
	}

	public function telCreate($field, $model, $page) {
		return view('dash::resource.renderElements.tel.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function telUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.tel.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}