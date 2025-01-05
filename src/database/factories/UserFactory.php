<?php

namespace Database\Factories;

use App\Persistence\Eloquent\Model\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = UserModel::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->userName(),
            'keycloak_id' => fake()->unique()->uuid(),
        ];
    }
}
