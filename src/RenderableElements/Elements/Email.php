<?php
namespace Dash\RenderableElements\Elements;

trait Email {

	public function getEmailElement($field, $model, $page) {
		return $page == 'create'?
		$this->emailCreate($field, $model, $page):
		$this->emailUpdate($field, $model, $page);
	}

	public function emailCreate($field, $model, $page) {
		return view('dash::resource.renderElements.email.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function emailUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.email.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}