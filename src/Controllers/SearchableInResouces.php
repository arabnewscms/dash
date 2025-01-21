<?php
namespace Dash\Controllers;
use App\Http\Controllers\Controller;

class SearchableInResouces extends Controller {

	public function handel_search() {
		$searchList = [];
		// Load All Resources
		foreach (app('dash')['resources'] as $resource) {
            $checkAvailabilSearch = $resource::$appendToMainSearch;
			if ($checkAvailabilSearch) {
				$resourceName = resourceShortName($resource);
				$searchList[] = [
					'model'        => $resource::$model,
					'columns'      => $resource::$search,
					'title'        => $resource::$title,
					'icon'         => $resource::$icon,
					'stringName'   => $resource::customName()??$resourceName,
					'resourceName' => $resourceName,
					'searchWithRelation' => $resource::$searchWithRelation,
				];
			}
		}
		$prepareLinks = [];
		foreach ($searchList as $search) {
			if (class_exists($search['model'])) {

				$model = $search['model'];

				if (method_exists($search['model'], 'translate')) {
					$i     = 0;
					$model = $model::select('id');
					foreach ($search['searchWithRelation'] as $relations) {
                        foreach($relations as $column) {
                            if ($i == 0) {
                                $model = $model->whereTranslationLike($column, '%'.request('search').'%');

                            } else {
                                $model = $model->orWhereTranslationLike($column, '%'.request('search').'%');
                            }
                            $i++;
                        }
					}

				} else {

					$i = 0;
					foreach ($search['columns'] as $column) {
						if ($i == 0) {
							$model = $model::where($column, 'LIKE', '%'.request('search').'%');
						} else {
							$model->orWhere($column, 'LIKE', '%'.request('search').'%');
						}
						$i++;
					}

				}

				$model = $model->orderBy('id', 'desc')->limit(5);
				if (method_exists($search['model'], 'translate')) {
					$model        = $model->get([$search['title'], 'id']);
					$hasTranslate = 'yes';
				} else {
					$model        = $model->pluck($search['title'], 'id');
					$hasTranslate = 'no';
				}

				$prepareLinks[$search['resourceName']] = [
					'icon'         => $search['icon'],
					'stringName'   => $search['stringName'],
					'title'        => $search['title'],
					'hasTranslate' => $hasTranslate,
					'data'         => $model,
				];
			}
		}

		return $this->renderSearchList($prepareLinks);
	}

	public function renderSearchList(array $output) {
		return view('dash::search_result', ['output' => $output])->render();
	}
}
