<?php

namespace Dash\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use Str;

class FileManagerModel extends Model
{
    use SoftDeletes;
    protected $table    = 'filemanager';
    protected $dates    = ['deleted_at'];
    protected $casts    = ['id' => 'integer'];
    protected $fillable = [
        'user_id',
        'file',
        'full_path',
        'storage_type',
        'url',
        'file_type',
        'file_id',
        'path',
        'ext',
        'name',
        'size',
        'size_bytes',
        'mimtype',
    ];

    public function __construct()
    {
        parent::__construct();
        if (Schema::hasColumn('filemanager', 'id') &&  in_array(Schema::getColumnType('filemanager', 'id'), ['uuid', 'char'])) {
            $this->casts['id'] = 'string';
        }
    }

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if (Schema::hasColumn('filemanager', 'id') &&  in_array(Schema::getColumnType('filemanager', 'id'), ['uuid', 'char'])) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function getIdAttribute($value)
    {
        // Check if the column is UUID or CHAR
        if (Schema::hasColumn($this->getTable(), 'id') && in_array(Schema::getColumnType($this->getTable(), 'id'), ['uuid', 'char'])) {
            // Convert to string if column is UUID or CHAR
            return (string) $value;
        }

        // Return the ID as it is for other column types (e.g., INT)
        return $value;
    }

    public function user()
    {
        return \DB::table('users')->where('id', $this->user_id)->first();
    }
}
