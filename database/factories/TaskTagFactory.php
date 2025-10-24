<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\TaskTags\TaskTagModel;
use Modules\Tasks\TaskModel;
use Modules\Tags\TagModel;

class TaskTagFactory extends Factory
{
    protected $model = TaskTagModel::class;

    public function definition(): array
    {
        return [
            'task_id' => TaskModel::inRandomOrder()->first()?->id ?? TaskModel::factory(),
            'tag_id' => TagModel::inRandomOrder()->first()?->id ?? TagModel::factory(),
        ];
    }
}
