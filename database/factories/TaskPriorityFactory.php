<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\TaskPriorities\TaskPriorityModel;

class TaskPriorityFactory extends Factory
{
    protected $model = TaskPriorityModel::class;

    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->word,
            'name' => $this->faker->word,
            'ordering' => $this->faker->numberBetween(1, 10),
        ];
    }
}
