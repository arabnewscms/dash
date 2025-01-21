<?php
namespace Dash\RenderableElements\Elements;

trait Video {

	public function getVideoElement($field, $model, $page) {
		return $page == 'create'?
		$this->videoCreate($field, $model, $page):
		$this->videoUpdate($field, $model, $page);
	}

	public function videoCreate($field, $model, $page) {
		return view('dash::resource.renderElements.video.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function videoUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.video.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}