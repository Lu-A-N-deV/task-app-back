<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Teams\TeamModel;

class TeamFactory extends Factory
{
    protected $model = TeamModel::class;

    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->unique()->company),
            'description' => $this->faker->optional()->sentence,
        ];
    }
}
