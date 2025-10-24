<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\TaskTypes\TaskTypeModel;

class TaskTypeFactory extends Factory
{
    protected $model = TaskTypeModel::class;

    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->word,
            'name' => $this->faker->word,
        ];
    }
}
