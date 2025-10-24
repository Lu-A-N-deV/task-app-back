<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Modules\Users\UserModel;
use Modules\Genres\GenreModel;
use Modules\SystemRoles\SystemRoleModel;

class UserFactory extends Factory
{
    protected $model = UserModel::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'second_last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'genre_id' => GenreModel::inRandomOrder()->first()?->id ?? GenreModel::factory(),
            'system_role_id' => SystemRoleModel::inRandomOrder()->first()?->id ?? SystemRoleModel::factory(),
        ];
    }
}
