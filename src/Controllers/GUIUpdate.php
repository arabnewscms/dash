<?php
namespace Dash\Controllers;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
class GUIUpdate extends Controller {

    public function extractNow($url) {
		$savePath = 'dashupdates/dash.zip';
		if (!\File::exists(storage_path('app/public/dashupdates'))) {
			\File::makeDirectory(storage_path('app/public/dashupdates'), 0755, true);
		}

		$guzzle = new Client(['verify' => false]);
		$response = $guzzle->get($url);
		\Storage::disk('public')->put($savePath, $response->getBody());

		$zip = new \ZipArchive();
		$status = $zip->open(storage_path('app/public/' . $savePath), \ZipArchive::CREATE);
		if ($status === true) {

			if ($zip->extractTo(base_path('/'))) {
				$zip->close();
				if (\Storage::disk('public')->exists($savePath)) {
					\Storage::disk('public')->delete($savePath);
				}
                $this->pushingUpdateFiles();
                $this->pushingUpdateToDashConfig();

                if(function_exists('shell_exec')) {
                    shell_exec('composer update');
                }elseif(function_exists('exec')) {
                    exec('composer update');
                }

                return true;
			}
		}
        return false;
	}

    public function gui_update_now(){
        $url =  request('url');
        $update =  $this->extractNow($url);

            return response([
                'status'=>$update,
            ]);

    }


    public function pushingUpdateFiles(){

        if (\File::exists(public_path('dashboard'))){
            \File::deleteDirectory(public_path('dashboard'));
        }
        \File::copyDirectory(base_path('dash/src/publish/public/dashboard'), public_path('dashboard'));
    }

    public function pushingUpdateToDashConfig(){
        // add FILESYSTEM_DISK
        if(!empty(array_keys(config('dash'))) && !in_array('FILESYSTEM_DISK',array_keys(config('dash')))){
            $dash_config = file_get_contents(config_path('dash.php'));
            $new_key = "        /**
            *  FILE SYSTEM DISK DRIVER YOU CAN Use public,s3
            * @param string
            */
            'FILESYSTEM_DISK'=>env('FILESYSTEM_DISK','public'),

        ];";
        $dash_config = str_replace('];',$new_key,$dash_config);
        file_put_contents(config_path('dash.php'),$dash_config);

        }

        // add DARK_MODE
        if(!empty(array_keys(config('dash'))) && !in_array('DARK_MODE',array_keys(config('dash')))){
            $dash_config = file_get_contents(config_path('dash.php'));
            $new_key = "         /**
            * DARK MODE Style with  on , off
            * @param string
            */
           'DARK_MODE' => env('DASH_DARK_MODE','on'),

        ];";
            $dash_config = str_replace('];',$new_key,$dash_config);
            file_put_contents(config_path('dash.php'),$dash_config);

        }


        // add CHECK_VERSION_MODE
        if(!empty(array_keys(config('dash'))) && !in_array('CHECK_VERSION_MODE',array_keys(config('dash')))){
            $dash_config = file_get_contents(config_path('dash.php'));
            $new_key = "         /**
            * CHECK  VERSION from phpdash.com with  on , off
            * @param string
            */
           'CHECK_VERSION_MODE' => env('CHECK_VERSION_MODE','off'),

        ];";
            $dash_config = str_replace('];',$new_key,$dash_config);
            file_put_contents(config_path('dash.php'),$dash_config);

        }



}

}
