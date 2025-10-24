<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SystemRoles\SystemRoleModel;

class SystemRoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['key' => 'admin', 'name' => 'Administrador', 'description' => 'Usuario con control total del sistema'],
            ['key' => 'user', 'name' => 'Usuario', 'description' => 'Usuario estándar con permisos limitados'],
            ['key' => 'guest', 'name' => 'Invitado', 'description' => 'Usuario con acceso restringido o temporal'],
        ];

        foreach ($roles as $role) {
            SystemRoleModel::create($role);
        }
    }
}
