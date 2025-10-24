<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\TaskComments\TaskCommentModel;
use Modules\Tasks\TaskModel;
use Modules\Users\UserModel;

class TaskCommentSeeder extends Seeder
{
    public function run(): void
    {
        $task = TaskModel::first() ?? TaskModel::factory()->create();
        $user = UserModel::where('system_role_id', 2)->first() ?? UserModel::factory()->create();

        TaskCommentModel::factory()->count(5)->create([
            'task_id' => $task->id,
            'user_id' => $user->id,
        ]);
    }
}
