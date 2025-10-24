<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Users\UserModel;
use Modules\Genres\GenreModel;
use Modules\SystemRoles\SystemRoleModel;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener o crear género por defecto
        $genre = GenreModel::first() ?? GenreModel::factory()->create();

        // Crear o buscar el rol de administrador
        $adminRole = SystemRoleModel::where('key', 'admin')->first()
            ?? SystemRoleModel::factory()->create(['key' => 'admin', 'name' => 'Administrador']);

        // Crear o buscar el rol de usuario
        $userRole = SystemRoleModel::where('key', 'user')->first()
            ?? SystemRoleModel::factory()->create(['key' => 'user', 'name' => 'Usuario']);

        // Crear usuario administrador
        UserModel::create([
            'username' => 'admin',
            'first_name' => 'Administrador',
            'last_name' => 'Principal',
            'second_last_name' => 'Del Sistema',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'genre_id' => $genre->id,
            'system_role_id' => $adminRole->id,
        ]);

        // Crear usuario estándar
        UserModel::create([
            'username' => 'user',
            'first_name' => 'Usuario',
            'last_name' => 'Regular',
            'second_last_name' => 'Del Sistema',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123456'),
            'genre_id' => $genre->id,
            'system_role_id' => $userRole->id,
        ]);
    }
}
