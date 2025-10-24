<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\TaskStatuses\TaskStatusModel;

class TaskStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['key' => 'backlog', 'name' => 'Backlog', 'ordering' => 1],
            ['key' => 'pending', 'name' => 'Pendiente', 'ordering' => 2],
            ['key' => 'ongoing', 'name' => 'En progreso', 'ordering' => 3],
            ['key' => 'completed', 'name' => 'Completada', 'ordering' => 4],
        ];

        foreach ($statuses as $status) {
            TaskStatusModel::create($status);
        }
    }
}
