<?php
namespace Dash\RenderableElements\Elements;

trait Color {

	public function getColorElement($field, $model, $page) {
		return $page == 'create'?
		$this->colorCreate($field, $model, $page):
		$this->colorUpdate($field, $model, $page);
	}

	public function colorCreate($field, $model, $page) {
		return view('dash::resource.renderElements.color.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function colorUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.color.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}