<?php

namespace Database\Factories;

use App\Persistence\Eloquent\Models\ProjetoModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjetoFactory extends Factory
{
    protected $model = ProjetoModel::class;

    public function definition(): array
    {
        return [
            'nome' => $this->faker->unique()->words(asText: true),
        ];
    }
}
