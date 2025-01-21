<?php
namespace Dash\RenderableElements\Elements;

trait Url {

	public function getUrlElement($field, $model, $page) {
		return $page == 'create'?
		$this->urlCreate($field, $model, $page):
		$this->urlUpdate($field, $model, $page);
	}

	public function urlCreate($field, $model, $page) {
		return view('dash::resource.renderElements.url.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function urlUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.url.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}