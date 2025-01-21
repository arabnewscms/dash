<?php
namespace Dash\RenderableElements\Elements;

trait Dropzone {

	public function getDropzoneElement($field, $model, $page) {
		return $page == 'create'?
		$this->DropzoneCreate($field, $model, $page):
		$this->DropzoneUpdate($field, $model, $page);
	}

	public function DropzoneCreate($field, $model, $page) {
		return view('dash::resource.renderElements.dropzone.dropzone', [
				'field'           => $field,
				'model'           => $model,
				'page'            => $page,
				"thumbnailWidth"  => isset($field['thumbnailWidth'])?$field['thumbnailWidth']:"80",
				"thumbnailHeight" => isset($field['thumbnailHeight'])?$field['thumbnailHeight']:"80",
				"parallelUploads" => isset($field['parallelUploads'])?$field['parallelUploads']:"20",
				"maxFiles"        => isset($field['maxFiles'])?$field['maxFiles']:"30",
				"maxFileSize"     => isset($field['maxFileSize'])?$field['maxFileSize']:"",
				"dz_param"        => $field['attribute'],
				"type"            => "create",
				"route"           => app('dash')['DASHBOARD_PATH'].'/resource/'.request()->segment(3),
				"path"            => strtolower(resourceShortName(get_class($model))),
			])->render();
	}

	public function DropzoneUpdate($field, $model, $page) {
		return view('dash::resource.renderElements.dropzone.dropzone', [
				'field'           => $field,
				'model'           => $model,
				'page'            => $page,
				"thumbnailWidth"  => isset($field['thumbnailWidth'])?$field['thumbnailWidth']:"80",
				"thumbnailHeight" => isset($field['thumbnailHeight'])?$field['thumbnailHeight']:"80",
				"parallelUploads" => isset($field['parallelUploads'])?$field['parallelUploads']:"20",
				"maxFiles"        => isset($field['maxFiles'])?$field['maxFiles']:"30",
				"maxFileSize"     => isset($field['maxFileSize'])?$field['maxFileSize']:"",
				"dz_param"        => $field['attribute'],
				"type"            => "edit",
				"route"           => app('dash')['DASHBOARD_PATH'].'/resource/'.request()->segment(3),
				"path"            => strtolower(resourceShortName(get_class($model))),
			])->render();
	}
}