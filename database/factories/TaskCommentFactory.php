<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\TaskComments\TaskCommentModel;
use Modules\Tasks\TaskModel;
use Modules\Users\UserModel;

class TaskCommentFactory extends Factory
{
    protected $model = TaskCommentModel::class;

    public function definition(): array
    {
        return [
            'task_id' => TaskModel::inRandomOrder()->first()?->id ?? TaskModel::factory(),
            'user_id' => UserModel::inRandomOrder()->first()?->id ?? UserModel::factory(),
            'comment' => $this->faker->sentence,
        ];
    }
}
