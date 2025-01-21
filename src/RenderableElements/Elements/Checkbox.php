<?php
namespace Dash\RenderableElements\Elements;

trait Checkbox {

	public function getCheckboxElement($field, $model, $page) {
		return $page == 'create'?
		$this->checkboxCreate($field, $model, $page):
		$this->checkboxUpdate($field, $model, $page);
	}

	public function checkboxCreate($field, $model, $page) {
		return view('dash::resource.renderElements.checkbox.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function checkboxUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.checkbox.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}