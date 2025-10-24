<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\TaskAttachments\TaskAttachmentModel;
use Modules\Tasks\TaskModel;
use Modules\Users\UserModel;

class TaskAttachmentSeeder extends Seeder
{
    public function run(): void
    {
        $task = TaskModel::first() ?? TaskModel::factory()->create();
        $user = UserModel::where('system_role_id', 2)->first() ?? UserModel::factory()->create();

        TaskAttachmentModel::factory()->count(3)->create([
            'task_id' => $task->id,
            'uploaded_by' => $user->id,
        ]);
    }
}
