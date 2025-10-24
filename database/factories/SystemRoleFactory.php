<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SystemRoles\SystemRoleModel;

class SystemRoleFactory extends Factory
{
    protected $model = SystemRoleModel::class;

    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->word,
            'name' => ucfirst($this->faker->unique()->jobTitle),
            'description' => $this->faker->sentence,
        ];
    }
}
