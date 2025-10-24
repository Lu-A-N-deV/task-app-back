<?php

namespace Modules\SystemRoles;

use App\Http\Controllers\GenericController;

class SystemRoleController extends GenericController
{
    protected string $model = SystemRoleModel::class;

    protected array $createRules = [
        'key' => 'required|string|unique:system_roles,key',
        'name' => 'required|string',
        'description' => 'nullable|string',
    ];

    protected array $updateRules = [
        'key' => 'sometimes|string|unique:system_roles,key',
        'name' => 'sometimes|string',
        'description' => 'nullable|string',
    ];
}
