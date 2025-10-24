<?php

namespace Modules\TaskTypes;

use Database\Factories\TaskTypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskTypeModel extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'task_types';

    protected static function newFactory()
    {
        // Nombre de la nueva Factory
        return TaskTypeFactory::new();
    }

    // Campos de la tabla
    protected $fillable = ['key', 'name'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    // Relación con TaskModel
    public function tasks()
    {
        return $this->hasMany(\Modules\Tasks\TaskModel::class, 'task_type_id');
    }
}
