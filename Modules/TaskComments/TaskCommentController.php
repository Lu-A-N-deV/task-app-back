<?php

namespace Modules\TaskComments;

use App\Http\Controllers\GenericController;

class TaskCommentController extends GenericController
{
    protected string $model = TaskCommentModel::class;

    protected array $createRules = [
        'task_id' => 'required|integer|exists:tasks,id',
        'user_id' => 'required|uuid|exists:users,id',
        'comment' => 'required|string',
    ];

    protected array $updateRules = [
        'task_id' => 'sometimes|integer|exists:tasks,id',
        'user_id' => 'sometimes|uuid|exists:users,id',
        'comment' => 'sometimes|string',
    ];
}
