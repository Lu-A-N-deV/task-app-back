<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Tags\TagModel;
use Modules\Teams\TeamModel;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $team = TeamModel::first() ?? TeamModel::factory()->create();

        $tags = [
            ['team_id' => $team->id, 'name' => 'UI', 'color' => '#FF5733'],
            ['team_id' => $team->id, 'name' => 'Backend', 'color' => '#33C1FF'],
            ['team_id' => $team->id, 'name' => 'Hotfix', 'color' => '#FF33A8'],
        ];

        foreach ($tags as $tag) {
            TagModel::create($tag);
        }
    }
}
