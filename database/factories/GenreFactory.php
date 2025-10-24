<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Genres\GenreModel;

class GenreFactory extends Factory
{
    protected $model = GenreModel::class;

    public function definition(): array
    {
        return [
            'key' => strtoupper($this->faker->unique()->lexify('??')),
            'name' => ucfirst($this->faker->unique()->word),
        ];
    }
}
