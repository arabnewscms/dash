<?php
namespace Dash\RenderableElements\Elements;

trait Audio {

	public function getAudioElement($field, $model, $page) {
		return $page == 'create'?
		$this->audioCreate($field, $model, $page):
		$this->audioUpdate($field, $model, $page);
	}

	public function audioCreate($field, $model, $page) {
		return view('dash::resource.renderElements.audio.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function audioUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.audio.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}