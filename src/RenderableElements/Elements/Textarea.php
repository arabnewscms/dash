<?php
namespace Dash\RenderableElements\Elements;

trait Textarea {

	public function getTextareaElement($field, $model, $page) {
		return $page == 'create'?
		$this->textareaCreate($field, $model, $page):
		$this->textareaUpdate($field, $model, $page);
	}

	public function textareaCreate($field, $model, $page) {
		return view('dash::resource.renderElements.textarea.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function textareaUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.textarea.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}