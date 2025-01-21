<?php
namespace Dash\RenderableElements\Elements;

trait Week {

	public function getWeekElement($field, $model, $page) {
		return $page == 'create'?
		$this->weekCreate($field, $model, $page):
		$this->weekUpdate($field, $model, $page);
	}

	public function weekCreate($field, $model, $page) {
		return view('dash::resource.renderElements.week.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function weekUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.week.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}