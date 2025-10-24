<?php

namespace Modules\TeamRoles;

use App\Http\Controllers\GenericController;

class TeamRoleController extends GenericController
{
    protected string $model = TeamRoleModel::class;

    protected array $createRules = [
        'team_id' => 'required|integer|exists:teams,id',
        'key' => 'required|string|unique:team_roles,key',
        'name' => 'required|string',
        'description' => 'nullable|string',
    ];

    protected array $updateRules = [
        'team_id' => 'sometimes|integer|exists:teams,id',
        'key' => 'required|string|unique:team_roles,key',
        'name' => 'sometimes|string',
        'description' => 'nullable|string',
    ];
}
