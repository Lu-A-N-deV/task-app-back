<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\TeamUsers\TeamUserModel;
use Modules\Teams\TeamModel;
use Modules\Users\UserModel;
use Modules\TeamRoles\TeamRoleModel;

class TeamUserSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener equipo, usuario y rol de equipo por defecto
        $team = TeamModel::first() ?? TeamModel::factory()->create();
        $user = UserModel::where('system_role_id', 2)->first() ?? UserModel::factory()->create();
        $role = TeamRoleModel::first() ?? TeamRoleModel::factory()->create(['team_id' => $team->id]);

        TeamUserModel::create([
            'team_id' => $team->id,
            'user_id' => $user->id,
            'team_role_id' => $role->id,
        ]);
    }
}
