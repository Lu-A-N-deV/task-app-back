<?php

namespace Modules\Tags;

use App\Http\Controllers\GenericController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends GenericController
{
    protected string $model = TagModel::class;

    protected array $createRules = [
        'team_id' => 'required|integer|exists:teams,id',
        'name' => 'required|string',
        'color' => 'nullable|string',
    ];

    protected array $updateRules = [
        'team_id' => 'sometimes|integer|exists:teams,id',
        'name' => 'sometimes|string',
        'color' => 'nullable|string',
    ];

    public function getTagsByTeam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'team_id' => 'required|integer|exists:teams,id',
        ]);

        if ($validator->fails()) return $this->validationErrorsResponse($validator);

        try {
            $tags = $this->model()::where('team_id', $request->input('team_id'))->get();
            // $team = TeamModel::find($request->input('team_id'));
            // $tags = $team->tags; // Obtiene todos los tags del equipo

            return $tags->isNotEmpty()
                ? response()->json($tags, 200)
                : $this->notFoundResponse('No se encontraron etiquetas por el equipo indicado');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Buscar etiquetas por equipo', $e);
        }
    }
}
