<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\TaskAttachments\TaskAttachmentModel;
use Modules\Tasks\TaskModel;
use Modules\Users\UserModel;

class TaskAttachmentFactory extends Factory
{
    protected $model = TaskAttachmentModel::class;

    public function definition(): array
    {
        return [
            'task_id' => TaskModel::inRandomOrder()->first()?->id ?? TaskModel::factory(),
            'uploaded_by' => UserModel::inRandomOrder()->first()?->id ?? UserModel::factory(),
            'filepath' => 'uploads/' . $this->faker->uuid . '.bin',
        ];
    }
}
