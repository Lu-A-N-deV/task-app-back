<?php

namespace Modules\TaskStatuses;

use App\Http\Controllers\GenericController;

class TaskStatusController extends GenericController
{
    protected string $model = TaskStatusModel::class;

    protected array $createRules = [
        'key' => 'required|string|unique:task_statuses,key',
        'name' => 'required|string',
        'ordering' => 'required|integer',
    ];

    protected array $updateRules = [
        'key' => 'sometimes|string|unique:task_statuses,key',
        'name' => 'sometimes|string',
        'ordering' => 'sometimes|integer',
    ];
}
