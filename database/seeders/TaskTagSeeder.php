<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\TaskTags\TaskTagModel;
use Modules\Tasks\TaskModel;
use Modules\Tags\TagModel;

class TaskTagSeeder extends Seeder
{
    public function run(): void
    {
        $task = TaskModel::first() ?? TaskModel::factory()->create();
        $tag = TagModel::first() ?? TagModel::factory()->create();

        TaskTagModel::create([
            'task_id' => $task->id,
            'tag_id' => $tag->id,
        ]);
    }
}
