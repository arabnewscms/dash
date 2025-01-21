<?php
namespace Dash\Controllers;
use App\Http\Controllers\Controller;
use SuperClosure\Serializer;

//use Dash\Controllers\FileUploader;

class DashboardTools extends Controller {

	public function deleteFilesByModel() {
		$model = request('model')::find(request('id'));
		if (!empty($model)) {
			if (filter_var($model->{request('column')}, FILTER_VALIDATE_URL)) {
                $file = parse_url($model->{request('column')})['path']??'';
                if(!empty($file)){
                    \Storage::disk(config('dash.FILESYSTEM_DISK'))->delete($file);
                }
			} else {
				\Storage::disk(config('dash.FILESYSTEM_DISK'))->delete($model->{request('column')});
			}
			$model->{request('column')} = '';
			$model->save();
			return response(['status' => true], 200);
		} else {
			return response(['status' => false], 200);
		}

	}

	public function load_model() {
		if (!empty(request('model_value'))) {
			$model = request('model_value');
			$all   = [];
			if (class_exists($model)) {

				if (!empty(request('model_query'))) {
					$unserialized = (new Serializer())->unserialize(request('model_query'));
					$model        = $unserialized($model);
				} else {
					$model = $model::query();
				}

				// get data by parent id like user_id = 1
				if (!empty(request('parent')) && !empty(request('column'))) {
					$data = $model->where(request('column'), request('parent'))->get();
				} elseif (request('withTrashed') == 'true') {
					$data = $model->onlyTrashed()->get();
				} else {
					$data = $model->get();
				}

				// organize data like pluck with translation astromic
				foreach ($data as $item) {
					if (method_exists($model, 'translate')) {
						if (!empty($item->translate(request('locale'))->{request('stringName')})) {
							$all[$item->id] = $item->translate(request('locale'))->{request('stringName')};
						} else {
							$all[$item->id] = $item->{request('stringName')};
						}
					} else {
						$all[$item->id] = $item->{request('stringName')};
					}
				}
				return $all;
			}
		}
	}

	public function dynamic_select2_search() {
		$searchKey = request('searchKey');
		$model     = request('model');
		$queryStr  = request('queryStr');
		if (!empty($queryStr)) {
			//dd($queryStr,$model);
			$unserialized = (new Serializer())->unserialize($queryStr);
			//$eloquent     = is_string($unserialized($model))?$unserialized($model):$unserialized($model);
			$eloquent     = $unserialized($model);
		} else {
			$eloquent = $model::query();
		}

		// if have parent && Child
		if (!empty(request('column')) && !empty(request('parent_value'))) {
			$eloquent = $eloquent->where(request('column'), request('parent_value'));
		}

		if (!empty(request('search'))) {
			if (method_exists($model, 'translate')) {
				$eloquent = $eloquent->whereTranslationLike($searchKey, '%' . request('search') . '%');
			} else {
				$eloquent = $eloquent->where($searchKey, 'LIKE', '%' . request('search') . '%');
			}
		}

		if (request('withTrashed') && request('withTrashed') == true) {
        if(method_exists($eloquent,'withTrashed')){
			$eloquent = $eloquent->onlyTrashed();
         }
		}
		$eloquent = $eloquent->paginate(50);

		$morePages = true;
		if (empty($eloquent->nextPageUrl())) {
			$morePages = false;
		}

		$eloquent = $eloquent->map(function ($item, $key) use ($searchKey) {
			return [
				'id'   => $item->id,
				'text' => $item->{$searchKey},
			];
		});
		return response([
			'results'    => $eloquent,
			'pagination' => [
				"more" => $morePages,
			],
		]);
	}

    public function get_statistics(){
        $model = request('model');
        $range = request('range');
        $typeCalc = request('typeCalc','count');
        if($range == 'today'){
            $from = now()->format('Y-m-d 00:00:00');
            $between = [$from,now()->format('Y-m-d 23:59:59')];
        }elseif($range == 'yesterday'){
            $from = now()->subDay()->format('Y-m-d 00:00:00');
            $between = [$from,now()->format('Y-m-d 23:59:59')];
        }elseif($range == 'week'){
            $from = now()->subWeek()->format('Y-m-d 00:00:00');
            $between = [$from,now()->format('Y-m-d 23:59:59')];
        }elseif($range == 'month'){
            $from = now()->subMonth()->format('Y-m-d 00:00:00');
            $between = [$from,now()->format('Y-m-d 23:59:59')];
        }elseif($range == 'year'){
            $from = now()->subYear()->format('Y-m-d 00:00:00');
            $between = [$from,now()->format('Y-m-d 23:59:59')];
        }elseif($range == 'all'){
            $between = [];
        }elseif(intval($range)){
            $from = now()->subDays($range)->format('Y-m-d 00:00:00');
            $between = [$from,now()->format('Y-m-d 23:59:59')];
        }

         $result        =   app($model);

        if (!empty(request('query'))) {
            $result        =   $result->where(function($q){
                $unserialized  = (new Serializer())->unserialize(request('query'));
                return $unserialized($q);
            });
        }else{
            $result        =   app($model);
        }


        if(!empty($between)){
            $result = $result->whereBetween(request('at','created_at'),$between);
        }



        if($typeCalc == 'count'){
            $res_value = $result->count();
        }elseif($typeCalc == 'sum'){
            $res_value =  $result->sum(request('sumColumn'));
        }

        if (!empty(request('query_format'))) {
          $unserialized_query_format  = (new Serializer())->unserialize(request('query_format'));
          $output = $unserialized_query_format($res_value);
        // dd("{$output}");
          return response([
            'result'=>$output
          ],200);
        }else{
          return  response([
            'result'=>$res_value
          ],200);
        }

    }

}
