<?php

namespace Modules\TaskAttachments;

use App\Http\Controllers\GenericController;

class TaskAttachmentController extends GenericController
{
    protected string $model = TaskAttachmentModel::class;

    protected array $createRules = [
        'task_id' => 'required|integer|exists:tasks,id',
        'uploaded_by' => 'required|uuid|exists:users,id',
        'filepath' => 'required|string',
    ];

    protected array $updateRules = [
        'task_id' => 'sometimes|integer|exists:tasks,id',
        'uploaded_by' => 'sometimes|uuid|exists:users,id',
        'filepath' => 'sometimes|string',
    ];
}
