<?php
namespace Dash\RenderableElements\Elements;

trait Select {

	public function getSelectElement($field, $model, $page) {
		return $page == 'create'?
		$this->selectCreate($field, $model, $page):
		$this->selectUpdate($field, $model, $page);
	}

	public function selectCreate($field, $model, $page) {
		return view('dash::resource.renderElements.select.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function selectUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.select.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}