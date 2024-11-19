<?php

namespace Database\Factories;

use App\Persistence\Eloquent\Models\DemandaModel;
use App\Persistence\Eloquent\Models\ProjetoModel;
use App\Persistence\Eloquent\Models\SprintModel;
use App\Persistence\Eloquent\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class DemandaFactory extends Factory
{
    protected $model = DemandaModel::class;

    public function definition(): array
    {
        return [
            'projeto_id' => ProjetoModel::factory(),
            'sprint_id' => SprintModel::factory(),
            'status_id' => $this->faker->numberBetween(1, 3),
            'user_relator_id' => UserModel::factory(),
            'user_responsavel_id' => UserModel::factory(),
            'jira_id' => $this->faker->randomElement(["SQ", "POR", "IA"]) . "-" . $this->faker->randomNumber(4, true),
            'titulo' => $this->faker->sentence(6),
            'descricao' => $this->faker->paragraph(),
            'data_entrega' => $this->faker->dateTimeBetween('-2 month', '+2 month')->format("Y-m-d"),
            'urgencia' => $this->faker->randomElement(['Baixa', 'Média', 'Alta']),
        ];
    }
}
