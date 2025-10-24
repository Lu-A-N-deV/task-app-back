<?php

namespace Modules\TaskStatuses;

use Database\Factories\TaskStatusFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskStatusModel extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'task_statuses';

    protected static function newFactory()
    {
        // Nombre de la nueva Factory
        return TaskStatusFactory::new();
    }

    // Campos de la tabla
    protected $fillable = ['key', 'name', 'ordering'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    // Relación con TaskModel
    public function tasks()
    {
        return $this->hasMany(\Modules\Tasks\TaskModel::class, 'task_status_id');
    }
}
