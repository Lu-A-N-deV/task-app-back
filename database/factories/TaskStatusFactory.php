<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\TaskStatuses\TaskStatusModel;

class TaskStatusFactory extends Factory
{
    protected $model = TaskStatusModel::class;

    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->word,
            'name' => $this->faker->word,
            'ordering' => $this->faker->numberBetween(1, 10),
        ];
    }
}
