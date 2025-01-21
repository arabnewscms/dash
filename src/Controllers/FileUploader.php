<?php
namespace Dash\Controllers;
use Dash\Models\FileManagerModel;
use Storage;
trait FileUploader {

	public static

function upload($request, $path, $typeid = 'image', $id = null) {

		if (substr($path, -1) == '/') {
			$path = substr($path, 0, -1);
		}

		$file       = request()->file($request);
		$ext        = $file->getClientOriginalExtension();
		$name       = $file->getClientOriginalName();
		$size       = self::GetSize($file->getSize());
		$size_bytes = $file->getSize();
		$mimtype    = $file->getMimeType();
		$hashname   = $file->hashName();

		if (env('FILESYSTEM_DRIVER') == 's3') {
			$file = request()->file($request);

			$filePath = $path.'/'.$name;
			Storage::disk(env('FILESYSTEM_DRIVER', 's3'))->put($filePath, file_get_contents($file));
			$full_path = Storage::disk(env('FILESYSTEM_DRIVER', 's3'))->url($filePath);
		} else {
			$full_path = $file->store($path);
		}

		$upload = FileManagerModel::create([
				'user_id'    => auth()->guard('dash')->user()->id,
				'file'       => $hashname,
				'full_path'  => $full_path,
				'file_type'  => $typeid,
				'file_id'    => $id,
				'path'       => $path,
				'ext'        => $ext,
				'name'       => $name,
				'size'       => $size,
				'size_bytes' => $size_bytes,
				'mimtype'    => $mimtype,
			]);

		if (filter_var($upload->full_path, FILTER_VALIDATE_URL)) {
			return response([
					'url' => $upload->full_path,
					'id'  => $upload->id,
				], 200);
		} else {
			$url = Storage::disk(env('FILESYSTEM_DRIVER', 'public'))->url($upload->full_path);
			return response([
					'url' => $url,
					'id'  => $upload->id,
				], 200);
		}

	}

	public static function GetSize($bytes) {
		if ($bytes >= 1073741824) {
			$bytes = number_format($bytes/1073741824, 2).' GB';
		} elseif ($bytes >= 1048576) {
			$bytes = number_format($bytes/1048576, 2).' MB';
		} elseif ($bytes >= 1024) {
			$bytes = number_format($bytes/1024, 2).' KB';
		} elseif ($bytes > 1) {
			$bytes = $bytes.' bytes';
		} elseif ($bytes == 1) {
			$bytes = $bytes.' byte';
		} else {
			$bytes = '0 bytes';
		}
		return $bytes;
	}

}
