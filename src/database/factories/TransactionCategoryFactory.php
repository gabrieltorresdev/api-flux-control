<?php

namespace Database\Factories;

use App\Persistence\Eloquent\Model\TransactionCategoryModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionCategoryFactory extends Factory
{
    protected $model = TransactionCategoryModel::class;

    public function definition(): array
    {
        return [
            "name" => fake()->slug(2),
            "type" => fake()->randomElement(['income', 'expense']),
            "is_default" => false
        ];
    }
}
