<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\TaskPriorities\TaskPriorityModel;

class TaskPrioritySeeder extends Seeder
{
    public function run(): void
    {
        $priorities = [
            ['key' => 'low', 'name' => 'Baja', 'ordering' => 1],
            ['key' => 'medium', 'name' => 'Media', 'ordering' => 2],
            ['key' => 'high', 'name' => 'Alta', 'ordering' => 3],
            ['key' => 'urgent', 'name' => 'Urgente', 'ordering' => 4],
        ];

        foreach ($priorities as $priority) {
            TaskPriorityModel::create($priority);
        }
    }
}
