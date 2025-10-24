<?php

namespace Modules\Teams;

use App\Http\Controllers\GenericController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\TeamRoles\TeamRoleModel;
use Modules\TeamUsers\TeamUserModel;
use Modules\Users\UserModel;

class TeamController extends GenericController
{
    protected string $model = TeamModel::class;

    protected array $createRules = [
        'name' => 'required|string',
        'description' => 'nullable|string',
    ];

    protected array $updateRules = [
        'name' => 'sometimes|string',
        'description' => 'nullable|string',
    ];

    public function getTeamsByUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|uuid|exists:users,id',
        ]);

        if ($validator->fails()) return $this->validationErrorsResponse($validator);

        try {
            $userId = $request->input('user_id');

            $teams = DB::table('team_users as tu')
                ->join('teams as t', 'tu.team_id', '=', 't.id')
                ->join('team_roles as tr', 'tu.team_role_id', '=', 'tr.id')
                ->select(
                    't.id as team_id',
                    't.name as team_name',
                    't.description as team_description',
                    'tr.id as team_role_id',
                    'tr.key as team_role_key',
                    'tr.name as team_role_name'
                )
                ->where('tu.user_id', $userId)
                ->whereNull('tu.deleted_at')
                ->whereNull('t.deleted_at')
                ->whereNull('tr.deleted_at')
                ->get();

            return response()->json($teams, 200);
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Error al obtener los equipos del usuario', $e);
        }
    }

    public function createTeamWithBasicTeamRolesAndTeamAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'user_id' => 'required|uuid|exists:users,id',
        ]);

        if ($validator->fails()) return $this->validationErrorsResponse($validator);

        try {
            $input = $request->only(['name', 'description']);

            $team = $this->model()::create($input);

            $roles = [
                ['key' => 'project_admin', 'name' => 'Administrador del proyecto', 'description' => 'Responsable del equipo'],
                ['key' => 'team_member', 'name' => 'Miembro', 'description' => 'Miembro regular del equipo'],
            ];

            foreach ($roles as $role) {
                $role['team_id'] = $team->id;
                TeamRoleModel::create($role);
            }

            $user = UserModel::where('id', $request->input('user_id'))->first();
            $role = TeamRoleModel::where('key', 'project_admin')->first();

            TeamUserModel::create([
                'team_id' => $team->id,
                'user_id' => $user->id,
                'team_role_id' => $role->id,
            ]);

            return $this->successResponse('Equipo y roles creados correctamente');
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Crear Equipo con roles', $e);
        }
    }
}
