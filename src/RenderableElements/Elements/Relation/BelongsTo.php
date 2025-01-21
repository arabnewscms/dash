<?php
namespace Dash\RenderableElements\Elements\Relation;

trait BelongsTo {

	public function getbelongsToElement($field, $model, $page) {
		return $page == 'create'?
		$this->belongsToCreate($field, $model, $page):
		$this->belongsToUpdate($field, $model, $page);
	}

	public function belongsToCreate($field, $model, $page) {
		return view('dash::resource.renderElements.Relation.belongsTo.create', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}

	public function belongsToUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.Relation.belongsTo.update', [
				'field' => $field,
				'model' => $model,
				'page'  => $page,
			])->render();
	}
}