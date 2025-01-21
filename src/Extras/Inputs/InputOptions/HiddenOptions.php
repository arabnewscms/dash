<?php
namespace Dash\Extras\Inputs\InputOptions;

trait HiddenOptions {

	protected static $showInIndex           = true;
	protected static $showInCreate          = true;
	protected static $showInUpdate          = true;
	protected static $showInShow            = true;
	protected static $disableDwonloadButton = true;
	protected static $disablePreviewButton  = true;
	protected static $deleteable            = true;

	public static function onlyIndex($condition = true) {
		$result = is_object($condition) ? $condition() : $condition;
		if ($result) {
			static::$showInIndex  = true;
			static::$showInShow   = false;
			static::$showInCreate = false;
			static::$showInUpdate = false;
		}else{
            static::$showInIndex  = true;
			static::$showInShow   = false;
			static::$showInCreate = false;
			static::$showInUpdate = false;
        }
		return static::fillData();
	}

	public static function onlyForms($condition = true) {
		$result = is_object($condition) ? $condition() : $condition;
		if ($result) {
			static::$showInIndex  = false;
			static::$showInShow   = false;
			static::$showInCreate = true;
			static::$showInUpdate = true;
		}else{
            static::$showInIndex  = false;
			static::$showInShow   = false;
			static::$showInCreate = true;
			static::$showInUpdate = true;
        }
		return static::fillData();
	}

    public static function onlyForm($condition = true) {
		$result = is_object($condition) ? $condition() : $condition;
		if ($result) {
			static::$showInIndex  = false;
			static::$showInShow   = false;
			static::$showInCreate = true;
			static::$showInUpdate = true;
		}else{
            static::$showInIndex  = false;
			static::$showInShow   = false;
			static::$showInCreate = true;
			static::$showInUpdate = true;
        }
		return static::fillData();
	}

	public static function onlyShow($condition = true) {
		$result = is_object($condition) ? $condition() : $condition;
		if ($result) {
			static::$showInIndex  = true;
			static::$showInShow   = true;
			static::$showInCreate = false;
			static::$showInUpdate = false;
		}else{
            static::$showInIndex  = true;
			static::$showInShow   = true;
			static::$showInCreate = true;
			static::$showInUpdate = true;
        }
		return static::fillData();
	}

	public static function showInIndex($condition = true) {
		$result = is_object($condition) ? $condition() : $condition;
		if ($result) {
			static::$showInIndex = true;
		}else{
			static::$showInIndex = false;
        }
		return static::fillData();
	}

	public static function showInCreate($condition = true) {
		$result = is_object($condition) ? $condition() : $condition;
		if ($result) {
			static::$showInCreate = true;
		}else{
			static::$showInCreate = false;
        }
		return static::fillData();
	}

	public static function showInUpdate($condition = true) {
		$result = is_object($condition) ? $condition() : $condition;
		if ($result) {
			static::$showInUpdate = true;
		}else{
			static::$showInUpdate = false;
        }
		return static::fillData();
	}

	public static function showInShow($condition = true) {
		$result = is_object($condition) ? $condition() : $condition;
		if ($result) {
			static::$showInShow = true;
		}
		return static::fillData();
	}

	public static function showInAll($condition = true) {
		$result = is_object($condition) ? $condition() : $condition;
		if ($result) {
			static::$showInIndex  = true;
			static::$showInShow   = true;
			static::$showInCreate = true;
			static::$showInUpdate = true;
		}
		return static::fillData();
	}

	public static function hideInAll($condition = true) {
		$result = is_object($condition) ? $condition() : $condition;
		if ($result) {
			static::$showInIndex  = false;
			static::$showInShow   = false;
			static::$showInCreate = false;
			static::$showInUpdate = false;
		}
		return static::fillData();
	}

	public static function hideInIndex($condition = true) {
		$result = is_object($condition) ? $condition() : $condition;
		if ($result) {
			static::$showInIndex = false;
		}
		return static::fillData();
	}

	public static function hideInCreate($condition = true) {
		$result = is_object($condition) ? $condition() : $condition;
		if ($result) {
			static::$showInCreate = false;
		}
		return static::fillData();
	}

	public static function hideInUpdate($condition = true) {
		$result = is_object($condition) ? $condition() : $condition;
		if ($result) {
			static::$showInUpdate = false;
		}
		return static::fillData();
	}

	public static function hideInShow($condition = true) {
		$result = is_object($condition) ? $condition() : $condition;
		if ($result) {
			static::$showInShow = false;
		}
		return static::fillData();
	}

	public static function disablePreviewButton($condition = true) {
		$result = is_object($condition) ? $condition() : $condition;
		if ($result) {
			static::$disablePreviewButton = false;
		}
		return static::fillData();
	}

	public static function disableDownloadButton($condition = true) {
		$result = is_object($condition) ? $condition() : $condition;
		if ($result) {
			static::$disableDwonloadButton = false;
		}
		return static::fillData();
	}

	public static function deleteable($condition = true) {
		static::$deleteable = is_object($condition) ? $condition() : $condition;
		return static::fillData();
	}

	public static function deletable($condition = true) {
		static::$deleteable = is_object($condition) ? $condition() : $condition;
		return static::fillData();
	}

	public static function UpdateRules() {
		static::$input[static::$index - 1]['deleteable']            = static::$deleteable;
		static::$input[static::$index - 1]['disableDwonloadButton'] = static::$disableDwonloadButton;
		static::$input[static::$index - 1]['disablePreviewButton']  = static::$disablePreviewButton;

		static::$input[static::$index - 1]['show_rules'] = [
			'showInIndex'  => static::$showInIndex,
			'showInCreate' => static::$showInCreate,
			'showInUpdate' => static::$showInUpdate,
			'showInShow'   => static::$showInShow,
		];

	}

}
