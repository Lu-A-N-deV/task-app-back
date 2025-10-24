<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\TeamRoles\TeamRoleModel;
use Modules\Teams\TeamModel;

class TeamRoleFactory extends Factory
{
    protected $model = TeamRoleModel::class;

    public function definition(): array
    {
        return [
            'team_id' => TeamModel::inRandomOrder()->first()?->id ?? TeamModel::factory(),
            'key' => $this->faker->unique()->word,
            'name' => $this->faker->unique()->jobTitle,
            'description' => $this->faker->sentence,
        ];
    }
}
