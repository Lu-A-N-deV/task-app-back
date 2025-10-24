<?php

namespace Modules\Users;

use App\Http\Controllers\GenericController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) return $this->validationErrorsResponse($validator);

        try {
            // Determinar si el valor es un email o un username
            $input = $request->input('identifier');
            $user = null;

            if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
                $user = $this->model()::with('systemRole')->where('email', $input)->first();
            } else {
                $user = $this->model()::with('systemRole')->where('username', $input)->first();
            }

            // Verificar si el usuario existe y la contraseña es correcta
            if (!$user || !Hash::check($request->input('password'), $user->password)) {
                return $this->notFoundResponse('Credenciales incorrectas');
            }

            // Enviar la respuesta
            return response()->json([
                'id' => $user->id,
                'username' => $user->username,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'second_last_name' => $user->second_last_name,
                'email' => $user->email,
                'genre_id' => $user->genre_id,
                'system_role_key' => $user->systemRole->key ?? 'user',
            ], 200);
        } catch (\Exception $e) {
            return $this->serverErrorResponse('Error al intentar iniciar sesión', $e);
        }
    }
}
