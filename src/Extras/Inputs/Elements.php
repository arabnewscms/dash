<?php
namespace Dash\Extras\Inputs;

trait Elements {
	public static $index            = 0;
	protected static $element_types = [
		// Id Integer Element
		'id',
		// HTML Element
		'text',
		'hidden',
		'textarea',
		'ckeditor',
		'dropzone',
		'email',
		'select',
		'url',
		'tel',
		'search',
		'number',
		'month',
		'week',
		'password',
		'checkbox',
		'file',
		'image',
		'video',
		'audio',
		'color',
		'date',
		'datetime',
		'time',
		'customHtml', //  custom html renderable by view
		// Relation Elements
		'hasMany',
		'hasOne',
		'hasOneThrough',
		'hasManyThrough',
		'belongsTo',
		'belongsToMany',
		'morphOne',
		'morphTo',
		'morphMany',
		'morphToMany',
	];

	/**
	 * input type form element_types
	 * @param string
	 */
	public static $type;

	/**
	 * field name
	 * @param string
	 */
	public static $name;

	/**
	 * field attribute name in view
	 * @param string
	 */
	public static $attribute;

	/**
	 * inputs list
	 * @param array
	 */
	public static $input = [];

	/**
	 * model data
	 * @param object
	 */
	public static $model;

}