<?php

namespace Modules\TaskAttachments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskAttachmentModel extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'task_attachments';

    protected $fillable = [
        'task_id',
        'uploaded_by',
        'filepath',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected static function newFactory()
    {
        return \Database\Factories\TaskAttachmentFactory::new();
    }

    public function task()
    {
        return $this->belongsTo(\Modules\Tasks\TaskModel::class, 'task_id');
    }

    public function uploader()
    {
        return $this->belongsTo(\Modules\Users\UserModel::class, 'uploaded_by');
    }
}
