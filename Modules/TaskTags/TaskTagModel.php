<?php

namespace Modules\TaskTags;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskTagModel extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'task_tags';

    protected $fillable = [
        'task_id',
        'tag_id',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected static function newFactory()
    {
        return \Database\Factories\TaskTagFactory::new();
    }

    public function task()
    {
        return $this->belongsTo(\Modules\Tasks\TaskModel::class, 'task_id');
    }

    public function tag()
    {
        return $this->belongsTo(\Modules\Tags\TagModel::class, 'tag_id');
    }
}
