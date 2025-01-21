<?php
namespace Dash\Extras\Inputs;

class Card {
	protected static $title     = '';
	protected static $style     = '';
	protected static $footer    = '';
	protected static $icon      = '';
	protected static $content   = '';
	protected static $iconColor = '';
	protected static $column    = '3';

	public static function title($title) {
		static ::$title = !is_object($title)?$title:$title();
		return new static ;
	}

	public static function small() {
		self::$style = 'small';
		return new static ;
	}

	public static function footer($footer) {
		static ::$footer = !is_object($footer)?$footer:$footer();
		return new static ;
	}

	public static function color($iconColor) {
		$iconColor          = !is_object($iconColor)?$iconColor:$iconColor();
		static ::$iconColor = in_array($iconColor, ['primary', 'success', 'dark', 'info'])?$iconColor:'info';
		return new static ;
	}

	public static function icon($icon) {
		static ::$icon = !is_object($icon)?$icon:$icon();

		return new static ;
	}

	public static function column($column) {
		static ::$column = !is_object($column)?$column:$column();

		return new static ;
	}

	public static function content($content) {
		static ::$content = !is_object($content)?$content:$content();
		return new static ;
	}

	public static function render() {
		return view('dash::cards.'.static ::$style.'_card', [
				'title'     => static ::$title,
				'footer'    => static ::$footer,
				'icon'      => static ::$icon,
				'content'   => static ::$content,
				'iconColor' => static ::$iconColor,
				'column'    => static ::$column,
			])->render();
	}

}