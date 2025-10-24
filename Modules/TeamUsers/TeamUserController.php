<?php

namespace Modules\TeamUsers;

use App\Http\Controllers\GenericController;

class TeamUserController extends GenericController
{
    protected string $model = TeamUserModel::class;

    protected array $createRules = [
        'team_id' => 'required|integer|exists:teams,id',
        'user_id' => 'required|uuid|exists:users,id',
        'team_role_id' => 'required|integer|exists:team_roles,id',
    ];

    protected array $updateRules = [
        'team_id' => 'sometimes|integer|exists:teams,id',
        'user_id' => 'sometimes|uuid|exists:users,id',
        'team_role_id' => 'sometimes|integer|exists:team_roles,id',
    ];
}
