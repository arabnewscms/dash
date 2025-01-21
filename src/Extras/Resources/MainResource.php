<?php
namespace Dash\Extras\Resources;

trait MainResource {
	public static $model;
	public static $policy;
	public static $group;
	public static $groupTitle;
	public static $icon;
	public static $title              = '';
	public static $displayInMenu      = true;
	public static $appendToMainSearch = true;
	public static $search             = [];
	public static $searchWithRelation = [];

	// datatable
	public static $multiSelectRecord = true;
	public static $searching         = true;
	public static $lengthChange      = true;
	public static $ordering          = true;
	public static $processing        = true;
	public static $serverSide        = true;
	public static $scrollCollapse    = true;
	public static $scrollY           = false;
	public static $scrollX           = true;
	public static $paging            = true;
	public static $lengthMenu        = [50, 10, 15, 20, 25, 50, 100];
	//full_numbers,numbers,simple,scrolling
	public static $pagingType = 'full_numbers';

	public static function dtButtons() {
		$dtButtons = [
			//'pageLength',
			//'collection',
			//'selectedSingle',
			//'selectRows',
			//'selectColumns',
			//'selectCells',
			//'selectAll',
			//'searchPanes',
			//'searchBuilder',
			//'colvis',
			//'fixedColumns',
			//'colvisRestore',
			//'columnsToggle',
			//'colvisGroup',
			//'spacer',
			//'print',
			//'pdf',
			//'excel',
			//'csv',
			//'copy',
		];

		// $dtButtons[] = [
		// 	"extend" => "copy",
		// 	"text"   => __('dash::dash.copy'),
		// 	"key"    => ["key"    => "c", "altKey"    => true],
		// ];
		return $dtButtons;
	}

	public function query($model) {
		return $model;
	}

	public static function customName() {
		return null;
	}

	public static function vertex() {
		return [

		];
	}

	public function fields() {
		return [
		];
	}

	public function actions() {
		return [

		];
	}

	public function filters() {
		return [

		];
	}



}
