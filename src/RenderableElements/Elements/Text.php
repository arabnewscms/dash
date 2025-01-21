<?php
namespace Dash\RenderableElements\Elements;

trait Text {

	public function getTextElement($field, $model, $page) {
		return $page == 'create'?
		$this->textCreate($field, $model, $page):
		$this->textUpdate($field, $model, $page);
	}

	public function textCreate($field, $model, $page) {
		return view('dash::resource.renderElements.text.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function textUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.text.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}