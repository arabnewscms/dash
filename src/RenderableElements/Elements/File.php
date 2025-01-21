<?php
namespace Dash\RenderableElements\Elements;

trait File {

	public function getFileElement($field, $model, $page) {
		return $page == 'create'?
		$this->fileCreate($field, $model, $page):
		$this->fileUpdate($field, $model, $page);
	}

	public function fileCreate($field, $model, $page) {
		return view('dash::resource.renderElements.file.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function fileUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.file.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}