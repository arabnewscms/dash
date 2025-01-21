<?php
namespace Dash\RenderableElements\Elements\Relation;

trait BelongsToMany {

	public function getbelongsToManyElement($field, $model, $page) {
		return $page == 'create'?
		$this->belongsToManyCreate($field, $model, $page):
		$this->belongsToManyUpdate($field, $model, $page);
	}

	public function belongsToManyCreate($field, $model, $page) {
		return view('dash::resource.renderElements.Relation.belongsToMany.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function belongsToManyUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.Relation.belongsToMany.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}