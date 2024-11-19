<?php

namespace Database\Factories;

use App\Persistence\Eloquent\Models\ComentarioDemandaModel;
use App\Persistence\Eloquent\Models\DemandaModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComentarioDemandaFactory extends Factory
{
    protected $model = ComentarioDemandaModel::class;

    public function definition(): array
    {
        return [
            'autor' => $this->faker->name(),
            'conteudo' => $this->faker->paragraph(),
            'demanda_id' => DemandaModel::factory(),
        ];
    }
}
