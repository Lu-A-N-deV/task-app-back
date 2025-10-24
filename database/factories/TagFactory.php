<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tags\TagModel;
use Modules\Teams\TeamModel;

class TagFactory extends Factory
{
    protected $model = TagModel::class;

    public function definition(): array
    {
        return [
            'team_id' => TeamModel::inRandomOrder()->first()?->id ?? TeamModel::factory(),
            'name' => ucfirst($this->faker->unique()->word),
            'color' => $this->faker->optional()->hexColor,
        ];
    }
}
