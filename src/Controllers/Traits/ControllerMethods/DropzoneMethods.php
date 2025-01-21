<?php
namespace Dash\Controllers\Traits\ControllerMethods;
use Dash\Models\FileManagerModel;
use Illuminate\Filesystem\Filesystem;
use Storage;

trait DropzoneMethods {

	// Delete Files From Dropzone Library
	public function delete_file() {
		if (request("file_type") && request("file_id")) {
			$file = $this->getFile(strval(request("file_type")), request("file_id"),request('id'));
			if (!empty($file)) {
				$this->delete(null, null, $file->id);
				return response([
						"status" => true,
					], 200);
			}
		}
	}

	// Multi upload with dropzone
	public function multi_upload() {
		if (request()->ajax()) {
			$rules     = [];
			$dz_attach = request('dz_attach_param_name');
			if (request()->hasFile($dz_attach)) {
				$rules[$dz_attach] = "";
			}

			$this->validate(request(), $rules, [], [
					$dz_attach => 'dropzone attach',

				]);

			if (request()->hasFile($dz_attach)) {

				$upload = $this->upload($dz_attach, request("dz_path"), strval($this->resource['model']), request("dz_id"));
			}

			return response([
					"status" => true,
					"type"   => request("dz_type"),
					"file"   => FileManagerModel::where('full_path',$upload??'')->first(),
				], 200);
		}

	}

	public function upload($request, $path, $typeid = 'icon', $id = null, $uid = null, $admin_id = null, $resize = null) {

        if ($resize === null) {
			$resize = 'no';
		} else {
			$resize = 'yes';
		}
		if (substr($path, -1) == '/') {
			$path = substr($path, 0, -1);
		}
		if (is_string($request) || is_numeric($request) || is_int($request)) {
			$file = request()->file($request);
		} else if (is_object($request) || is_array($request)) {
			$file = $request;
		}
		$ext        = $file->getClientOriginalExtension();
		$size       = self::GetSize($file->getSize());
		$size_bytes = $file->getSize();
		$mimtype    = $file->getMimeType();
		$full_path  = $file->store($path,config('dash.FILESYSTEM_DISK'));
		$hashname   = $file->hashName();
        $url = Storage::disk(config('dash.FILESYSTEM_DISK'))->url($full_path);

		$upload = FileManagerModel::create([
				'user_id'    => auth()->guard('dash')->user()->id,
				'file'       => $hashname,
				'full_path'  => $full_path,
                'storage_type'=>config('dash.FILESYSTEM_DISK'),
				'url'        => $url,
				'file_type'  => strval($typeid),
				'file_id'    => $id,
				'path'       => $path,
				'ext'        => $ext,
				'name'       => $file->getClientOriginalName(),
				'size'       => $size,
				'size_bytes' => $size_bytes,
				'mimtype'    => $mimtype,
			]);

		return $upload->full_path;

	}

	public function getFile($file_type, $file_id,$id=null) {
		$file = FileManagerModel::where(function($q)use($file_type,$file_id,$id){
            if(!empty($id)){
                $q->where('id',$id);
            }else{
                $q->where('file_type', $file_type)->where('file_id', $file_id);
            }
        })->first();
		return $file;
	}

	public function rename($file_type, $file_id, $new_id) {
		$files    = FileManagerModel::where('file_type', strval($file_type))->where('file_id', $file_id)->get();
		$old_path = '';
		foreach ($files as $file) {
			// New Full path
            if(!empty($file->path)){


			if (Storage::disk(config('dash.FILESYSTEM_DISK'))->exists($file->path)) {
				$full_path = resourceShortName($file_type).'/'.$new_id.'/'.$file->file;
				Storage::disk(config('dash.FILESYSTEM_DISK'))->move($file->full_path, $full_path);
				$old_path = $file->path;
                $url = Storage::disk(config('dash.FILESYSTEM_DISK'))->url($full_path);
				// Update Information
				$file->url       = $url;
				$file->full_path = $full_path;
				$file->path      = resourceShortName($file_type).'/'.$new_id;
				$file->file_type = strval($file_type);
				$file->file_id   = $new_id;
				$file->save();
			} else {
				$file->delete();
			}
        }
		}
		if (!empty($old_path) && Storage::disk(config('dash.FILESYSTEM_DISK'))->exists($old_path)) {
			Storage::disk(config('dash.FILESYSTEM_DISK'))   ->deleteDirectory($old_path);
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

	/* Delete One File Where type and id */
	public function delete($id = null, $type = null, $specific = null) {
		$path = preg_match('/public/i', $id)?explode('public/', $id)[1]:$id;
		if (is_null($type) && !is_null($id) && !is_numeric($id) && !preg_match('/^[0-9a-f]{8}-([0-9a-f]{4}-){3}[0-9a-f]{12}$/i', $id)) {
			if (Storage::disk(config('dash.FILESYSTEM_DISK'))->exists($path)) {
				Storage::disk(config('dash.FILESYSTEM_DISK'))   ->delete($id);
			}
		} elseif (!is_null($specific) && is_numeric($specific) || preg_match('/^[0-9a-f]{8}-([0-9a-f]{4}-){3}[0-9a-f]{12}$/i', $specific)) {
			$delete = FileManagerModel::find($specific);
			if (!empty($delete)) {
				foreach ($this->sizes() as $key => $val) {
					if (Storage::disk(config('dash.FILESYSTEM_DISK'))->exists($delete->path)) {
						Storage::disk(config('dash.FILESYSTEM_DISK'))->delete($delete->path.$key.'_'.$delete->file);
					}
				}
				Storage::disk(config('dash.FILESYSTEM_DISK'))->delete($delete->full_path);
				//self::deleteDir($delete);
				$delete->forceDelete();
			}
		} elseif (!empty($type) and !empty($id) && empty($specific)) {
			$delete_all = FileManagerModel::where('file_type', $type)->where('file_id', $id)->get();
			foreach ($delete_all as $delete) {
				foreach ($this->sizes() as $key => $val) {
					if (Storage::disk(config('dash.FILESYSTEM_DISK'))->exists($delete->path.'/'.$val.'_'.$delete->file)) {
						Storage::disk(config('dash.FILESYSTEM_DISK'))->delete($delete->path.'/'.$val.'_'.$delete->file);
					}
				}
				Storage::disk(config('dash.FILESYSTEM_DISK'))->delete($delete->full_path);
				//self::deleteDir($delete);
				$delete->forceDelete();
			}
		}
	}

	/* Delete One File Where type and id */
	public static function deleteDir($delete) {
		$FileSystem = new Filesystem();
		// get current driver to prepare full path by config
        if(config('dash.FILESYSTEM_DISK') == 's3'){
            $path = $delete->path;
            Storage::disk(config('dash.FILESYSTEM_DISK'))->deleteDirectory($delete->path);
        }else{
            $path = config('filesystems.disks')[config('dash.FILESYSTEM_DISK')]['root'].'/'.$delete->path;
            if ($FileSystem->exists($path) && !$FileSystem->files($path)) {
                Storage::disk(config('dash.FILESYSTEM_DISK'))->deleteDirectory($delete->path);
                Storage::disk(config('dash.FILESYSTEM_DISK'))->deleteDirectory(resourceShortName($delete->file_type).'/'.$delete->file_id);
            }
        }
	}

	public static function sizes() {
		return [
			'25'   => '25',
			'50'   => '50',
			'100'  => '100',
			'200'  => '200',
			'300'  => '300',
			'400'  => '400',
			'500'  => '500',
			'1000' => '1000',
			'1024' => '1024',
			'2048' => '2048',
		];
	}
}
