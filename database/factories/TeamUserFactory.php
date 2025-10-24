<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\TeamUsers\TeamUserModel;
use Modules\Teams\TeamModel;
use Modules\Users\UserModel;
use Modules\TeamRoles\TeamRoleModel;

class TeamUserFactory extends Factory
{
    protected $model = TeamUserModel::class;

    public function definition(): array
    {
        return [
            'team_id' => TeamModel::inRandomOrder()->first()?->id ?? TeamModel::factory(),
            'user_id' => UserModel::inRandomOrder()->first()?->id ?? UserModel::factory(),
            'team_role_id' => TeamRoleModel::inRandomOrder()->first()?->id ?? TeamRoleModel::factory(),
        ];
    }
}
