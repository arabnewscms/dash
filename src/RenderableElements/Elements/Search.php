<?php
namespace Dash\RenderableElements\Elements;

trait Search {

	public function getSearchElement($field, $model, $page) {
		return $page == 'create'?
		$this->searchCreate($field, $model, $page):
		$this->searchUpdate($field, $model, $page);
	}

	public function searchCreate($field, $model, $page) {
		return view('dash::resource.renderElements.search.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function searchUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.search.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}