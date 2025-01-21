<?php
namespace Dash\RenderableElements\Elements;

trait Month {

	public function getMonthElement($field, $model, $page) {
		return $page == 'create'?
		$this->monthCreate($field, $model, $page):
		$this->monthUpdate($field, $model, $page);
	}

	public function monthCreate($field, $model, $page) {
		return view('dash::resource.renderElements.month.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function monthUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.month.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}