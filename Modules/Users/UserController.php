<?php

namespace Modules\Users;

use App\Http\Controllers\GenericController;

class UserController extends GenericController
{
    protected string $model = UserModel::class;

    protected string $pkRule = 'required|uuid';

    protected array $createRules = [
        'username' => 'required|string|max:255|unique:users,username',
        'first_name' => 'nullable|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'second_last_name' => 'nullable|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:6',
        'genre_id' => 'nullable|integer|exists:genres,id',
        'system_role_id' => 'required|integer|exists:system_roles,id',
    ];

    protected array $updateRules = [
        'username' => 'sometimes|string|max:255|unique:users,username',
        'first_name' => 'sometimes|string|max:255',
        'last_name' => 'sometimes|string|max:255',
        'second_last_name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|max:255|unique:users,email',
        'password' => 'sometimes|string|min:6',
        'genre_id' => 'sometimes|integer|exists:genres,id',
        'system_role_id' => 'sometimes|integer|exists:system_roles,id',
    ];
}
