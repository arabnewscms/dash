<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminGroupRole extends Model {
	use HasFactory;
	protected $fillable = [
		'id',
		'admin_group_id',
		'resource',
		'create',
		'show',
		'update',
		'delete',
		'force_delete',
		'restore',
	];

	public function admingroup() {
		return $this->belongsTo(AdminGroup::class, 'admin_group_id');
	}

	public function groups() {
		return $this->belongsToMany(AdminGroup::class);
	}
}
