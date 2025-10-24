<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\TeamRoles\TeamRoleModel;
use Modules\Teams\TeamModel;

class TeamRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener equipo por defecto
        $team = TeamModel::first() ?? TeamModel::factory()->create();

        $roles = [
            ['team_id' => $team->id, 'key' => 'project_admin', 'name' => 'Administrador del proyecto', 'description' => 'Responsable del equipo'],
            ['team_id' => $team->id, 'key' => 'team_member', 'name' => 'Miembro', 'description' => 'Miembro regular del equipo'],
        ];

        foreach ($roles as $role) {
            TeamRoleModel::create($role);
        }
    }
}
