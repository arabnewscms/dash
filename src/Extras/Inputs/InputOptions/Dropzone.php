<?php
namespace Dash\Extras\Inputs\InputOptions;

trait Dropzone {

	public static function autoQueue($autoQueue = true) {
		static ::$input[static ::$index-1]['autoQueue'] = is_object($autoQueue)?
		$autoQueue():
		$autoQueue;
		return static ::fillData();
	}

	public static function acceptedMimeTypes(...$acceptedMimeTypes) {
		static ::$input[static ::$index-1]['acceptedMimeTypes'] = is_object($acceptedMimeTypes)?
		$acceptedMimeTypes():
		$acceptedMimeTypes;
		return static ::fillData();
	}

	public static function maxFileSize($maxFileSize = 1000) {
		static ::$input[static ::$index-1]['maxFileSize'] = is_object($maxFileSize)?
		$maxFileSize():
		$maxFileSize;
		return static ::fillData();
	}

	public static function maxFiles($maxFiles = 30) {
		static ::$input[static ::$index-1]['maxFiles'] = is_object($maxFiles)?
		$maxFiles():
		$maxFiles;
		return static ::fillData();
	}

	public static function parallelUploads($parallelUploads = 20) {
		static ::$input[static ::$index-1]['parallelUploads'] = is_object($parallelUploads)?
		$parallelUploads():
		$parallelUploads;
		return static ::fillData();
	}

	public static function thumbnailWidth($thumbnailWidth = 80) {
		static ::$input[static ::$index-1]['thumbnailWidth'] = is_object($thumbnailWidth)?
		$thumbnailWidth():
		$thumbnailWidth;
		return static ::fillData();
	}

	public static function thumbnailHeight($thumbnailHeight = 80) {
		static ::$input[static ::$index-1]['thumbnailHeight'] = is_object($thumbnailHeight)?
		$thumbnailHeight():
		$thumbnailHeight;
		return static ::fillData();
	}

}