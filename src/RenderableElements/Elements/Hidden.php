<?php
namespace Dash\RenderableElements\Elements;

trait Hidden {

	public function getHiddenElement($field, $model, $page) {
		return $page == 'create'?
		$this->hiddenCreate($field, $model, $page):
		$this->hiddenUpdate($field, $model, $page);
	}

	public function hiddenCreate($field, $model, $page) {
		return view('dash::resource.renderElements.hidden.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function hiddenUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.hidden.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}