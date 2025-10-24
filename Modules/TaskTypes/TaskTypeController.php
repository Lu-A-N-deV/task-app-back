<?php

namespace Modules\TaskTypes;

use App\Http\Controllers\GenericController;

class TaskTypeController extends GenericController
{
    protected string $model = TaskTypeModel::class;

    protected array $createRules = [
        'key' => 'required|string|unique:task_types,key',
        'name' => 'required|string',
    ];

    protected array $updateRules = [
        'key' => 'sometimes|string|unique:task_types,key',
        'name' => 'sometimes|string',
    ];
}
