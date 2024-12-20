<?php

namespace Database\Factories;

use App\Persistence\Eloquent\Model\TransactionModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = TransactionModel::class;

    public function definition(): array
    {
        return [
            'amount' => fake()->randomFloat(2, 20, 5000),
            'date_time' => fake()->dateTimeBetween('2024-12-01', now()),
            'title' => fake()->title()
        ];
    }
}
