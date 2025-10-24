<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            GenreSeeder::class,
            SystemRoleSeeder::class,
            UserSeeder::class,
            TeamSeeder::class,
            TeamRoleSeeder::class,
            TeamUserSeeder::class,
            TaskTypeSeeder::class,
            TaskPrioritySeeder::class,
            TaskStatusSeeder::class,
            TaskSeeder::class,
            TaskCommentSeeder::class,
            TaskAttachmentSeeder::class,
            TagSeeder::class,
            TaskTagSeeder::class,
        ]);
    }
}
