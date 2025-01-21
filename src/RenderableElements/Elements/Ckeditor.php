<?php
namespace Dash\RenderableElements\Elements;

trait Ckeditor {

	public function getCkeditorElement($field, $model, $page) {
		return $page == 'create'?
		$this->ckeditorCreate($field, $model, $page):
		$this->ckeditorUpdate($field, $model, $page);
	}

	public function ckeditorCreate($field, $model, $page) {
		return view('dash::resource.renderElements.ckeditor.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function ckeditorUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.ckeditor.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}