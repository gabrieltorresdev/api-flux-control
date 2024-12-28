<?php

namespace Database\Factories;

use App\Persistence\Eloquent\Model\CategoryModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = CategoryModel::class;

    public function definition(): array
    {
        return [
            "name" => fake()->slug(2),
            "type" => fake()->randomElement(['income', 'expense']),
            "is_default" => false
        ];
    }
}
