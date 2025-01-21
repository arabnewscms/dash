<?php
namespace Dash\RenderableElements\Elements\Relation;

trait MorphTo {

	public function getmorphToElement($field, $model, $page) {
		return $page == 'create'?
		$this->morphToCreate($field, $model, $page):
		$this->morphToUpdate($field, $model, $page);
	}

	public function morphToCreate($field, $model, $page) {
		return view('dash::resource.renderElements.Relation.morphTo.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function morphToUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.Relation.morphTo.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}