<?php

namespace Modules\Tasks;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskModel extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'tasks';

    protected static function newFactory()
    {
        // Nombre de la nueva Factory
        return TaskFactory::new();
    }

    // Campos de la tabla
    protected $fillable = [
        'team_id',
        'title',
        'description',
        'task_type_id',
        'task_priority_id',
        'task_status_id',
        'created_by',
        'assigned_to',
        'due_date',
    ];

    // protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    // Relación con TeamModel
    public function team()
    {
        return $this->belongsTo(\Modules\Teams\TeamModel::class, 'team_id');
    }

    // Relación con TaskTypeModel
    public function type()
    {
        return $this->belongsTo(\Modules\TaskTypes\TaskTypeModel::class, 'task_type_id');
    }

    // Relación con TaskPriorityModel
    public function priority()
    {
        return $this->belongsTo(\Modules\TaskPriorities\TaskPriorityModel::class, 'task_priority_id');
    }

    // Relación con TaskStatusModel
    public function status()
    {
        return $this->belongsTo(\Modules\TaskStatuses\TaskStatusModel::class, 'task_status_id');
    }

    // Relación con UserModel (creador)
    public function createdBy()
    {
        return $this->belongsTo(\Modules\Users\UserModel::class, 'created_by');
    }

    // Relación con UserModel (asignado)
    public function assignedTo()
    {
        return $this->belongsTo(\Modules\Users\UserModel::class, 'assigned_to');
    }
}
