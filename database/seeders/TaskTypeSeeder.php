<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\TaskTypes\TaskTypeModel;

class TaskTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['key' => 'task', 'name' => 'Tarea'],
            ['key' => 'bug', 'name' => 'Bug'],
            ['key' => 'story', 'name' => 'Historia'],
            ['key' => 'improvement', 'name' => 'Mejora'],
        ];

        foreach ($types as $type) {
            TaskTypeModel::create($type);
        }
    }
}
