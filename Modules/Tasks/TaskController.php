<?php

namespace Modules\Tasks;

use App\Http\Controllers\GenericController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends GenericController
{
    protected string $model = TaskModel::class;

    protected array $createRules = [
        'team_id' => 'required|integer|exists:teams,id',
        'title' => 'required|string',
        'description' => 'nullable|string',
        'task_type_id' => 'required|integer|exists:task_types,id',
        'task_priority_id' => 'required|integer|exists:task_priorities,id',
        'task_status_id' => 'required|integer|exists:task_statuses,id',
        'created_by' => 'required|uuid|exists:users,id',
        'assigned_to' => 'nullable|uuid|exists:users,id',
        'due_date' => 'nullable|date',
    ];

    protected array $updateRules = [
        'team_id' => 'sometimes|integer|exists:teams,id',
        'title' => 'sometimes|string',
        'description' => 'nullable|string',
        'task_type_id' => 'sometimes|integer|exists:task_types,id',
        'task_priority_id' => 'sometimes|integer|exists:task_priorities,id',
        'task_status_id' => 'sometimes|integer|exists:task_statuses,id',
        'created_by' => 'sometimes|uuid|exists:users,id',
        'assigned_to' => 'nullable|uuid|exists:users,id',
        'due_date' => 'nullable|date',
    ];

    public function getTasksByTeam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'team_id' => 'required|integer|exists:teams,id',
        ]);

        if ($validator->fails()) return $this->validationErrorsResponse($validator);

        try {
            $tasks = $this->model()::where('team_id', $request->input('team_id'))->get();
            // $team = TeamModel::find($request->input('team_id'));
            // $tasks = $team->tasks; // Obtiene todos los tasks del equipo

            return $tasks->isNotEmpty()
                ? response()->json($tasks, 200)
                : $this->notFoundResponse('No se encontraron tareas por el equipo indicado');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Buscar tareas por equipo', $e);
        }
    }
}
