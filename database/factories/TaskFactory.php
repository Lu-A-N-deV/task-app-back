<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tasks\TaskModel;
use Modules\Teams\TeamModel;
use Modules\TaskTypes\TaskTypeModel;
use Modules\TaskPriorities\TaskPriorityModel;
use Modules\TaskStatuses\TaskStatusModel;
use Modules\Users\UserModel;

class TaskFactory extends Factory
{
    protected $model = TaskModel::class;

    public function definition(): array
    {
        return [
            'team_id' => TeamModel::inRandomOrder()->first()?->id ?? TeamModel::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'task_type_id' => TaskTypeModel::inRandomOrder()->first()?->id ?? TaskTypeModel::factory(),
            'task_priority_id' => TaskPriorityModel::inRandomOrder()->first()?->id ?? TaskPriorityModel::factory(),
            'task_status_id' => TaskStatusModel::inRandomOrder()->first()?->id ?? TaskStatusModel::factory(),
            'created_by' => UserModel::inRandomOrder()->first()?->id ?? UserModel::factory(),
            'assigned_to' => UserModel::inRandomOrder()->first()?->id ?? UserModel::factory(),
            'due_date' => $this->faker->dateTimeBetween('+1 days', '+1 month'),
        ];
    }
}
