<?php
namespace Dash\RenderableElements\Elements;

trait Password {

	public function getPasswordElement($field, $model, $page) {
		return $page == 'create'?
		$this->passwordCreate($field, $model, $page):
		$this->passwordUpdate($field, $model, $page);
	}

	public function passwordCreate($field, $model, $page) {
		return view('dash::resource.renderElements.password.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function passwordUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.password.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}