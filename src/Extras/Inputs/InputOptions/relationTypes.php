<?php
namespace Dash\Extras\Inputs\InputOptions;

trait relationTypes {
	protected $relationTypes = [
		'hasOne',
		'hasOneThrough',
		'hasManyThrough',
		'hasMany',
		'belongsTo',
		'belongsToMany',
		'morphOne',
		'morphTo',
		'morphMany',
		'morphToMany',
	];

	protected $relationManyTypes = [
		'hasManyThrough',
		'hasMany',
		'belongsToMany',
		'morphToMany',
		'morphedByMany',
		'morphMany',
	];

	protected $relationOneTypes = [
		'belongsTo',
		'hasOne',
		'hasOneThrough',
		'morphOne',
		'morphTo',
	];
}