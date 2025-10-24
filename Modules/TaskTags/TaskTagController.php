<?php

namespace Modules\TaskTags;

use App\Http\Controllers\GenericController;

class TaskTagController extends GenericController
{
    protected string $model = TaskTagModel::class;

    protected array $createRules = [
        'task_id' => 'required|integer|exists:tasks,id',
        'tag_id' => 'required|integer|exists:tags,id',
    ];

    protected array $updateRules = [
        'task_id' => 'sometimes|integer|exists:tasks,id',
        'tag_id' => 'sometimes|integer|exists:tags,id',
    ];
}
