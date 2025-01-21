<?php
namespace Dash;
abstract class Notification {

	public static function stack() {
		return [];
	}

	public static function unreadCount() {
		return 0;
	}

	public static function content() {
		return '<p>Notification Not Setted</p>';
	}
}