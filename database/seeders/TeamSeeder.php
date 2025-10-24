<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Teams\TeamModel;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $teams = [
            ['name' => 'Team_001', 'description' => 'First team created'],
        ];

        foreach ($teams as $team) {
            TeamModel::create($team);
        }
    }
}
