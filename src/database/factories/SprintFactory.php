<?php

namespace Database\Factories;

use App\Persistence\Eloquent\Models\SprintModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class SprintFactory extends Factory
{
    protected $model = SprintModel::class;

    public function definition(): array
    {
        $retorno = [
            'finalizada' => false
        ];

        $temDataInicio = $this->faker->boolean();
        if ($temDataInicio) {
            $retorno['data_inicio'] = $this->faker->dateTimeBetween('-1 month', 'now');

            $temDataFim = $this->faker->boolean();
            if ($temDataFim) {
                $retorno['finalizada'] = $this->faker->boolean();
                if ($retorno['finalizada']) {
                    $retorno['data_inicio'] = $this->faker->dateTimeBetween('-2 month', 'now');
                    $retorno['data_fim'] = $this->faker->dateTimeBetween('-1 month', 'now');
                } else {
                    $retorno['data_fim'] = $this->faker->dateTimeBetween('now', '+1 month');
                }

                $retorno['data_inicio'] = min($retorno['data_inicio'], $retorno['data_fim']);
                $retorno['data_fim'] = max($retorno['data_inicio'], $retorno['data_fim']);
            }
        }

        return $retorno;
    }
}
