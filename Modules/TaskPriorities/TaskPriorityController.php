<?php

namespace Modules\TaskPriorities;

use App\Http\Controllers\GenericController;

class TaskPriorityController extends GenericController
{
    protected string $model = TaskPriorityModel::class;

    protected array $createRules = [
        'key' => 'required|string|unique:task_priorities,key',
        'name' => 'required|string',
        'ordering' => 'required|integer',
    ];

    protected array $updateRules = [
        'key' => 'sometimes|string|unique:task_priorities,key',
        'name' => 'sometimes|string',
        'ordering' => 'sometimes|integer',
    ];
}
