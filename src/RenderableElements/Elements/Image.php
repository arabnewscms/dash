<?php
namespace Dash\RenderableElements\Elements;

trait Image {

	public function getImageElement($field, $model, $page) {
		return $page == 'create'?
		$this->imageCreate($field, $model, $page):
		$this->imageUpdate($field, $model, $page);
	}

	public function imageCreate($field, $model, $page) {
		return view('dash::resource.renderElements.image.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function imageUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.image.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}