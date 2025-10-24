<?php

namespace Modules\TaskComments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskCommentModel extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'task_comments';

    protected $fillable = [
        'task_id',
        'user_id',
        'comment',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected static function newFactory()
    {
        return \Database\Factories\TaskCommentFactory::new();
    }

    public function task()
    {
        return $this->belongsTo(\Modules\Tasks\TaskModel::class, 'task_id');
    }

    public function user()
    {
        return $this->belongsTo(\Modules\Users\UserModel::class, 'user_id');
    }
}
