<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Genres\GenreModel;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            ['key' => 'M', 'name' => 'Masculino'],
            ['key' => 'F', 'name' => 'Femenino'],
            ['key' => 'O', 'name' => 'Otro'],
        ];

        foreach ($genres as $genre) {
            GenreModel::create($genre);
        }
    }
}
