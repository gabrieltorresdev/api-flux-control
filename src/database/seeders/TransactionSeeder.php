<?php

namespace Database\Seeders;

use App\Core\Domain\Entity\Category;
use App\Core\Domain\Entity\Transaction;
use App\Persistence\Eloquent\Model\CategoryModel;
use App\Persistence\Eloquent\Model\TransactionModel;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $categories = CategoryModel::all();

        if ($categories->isEmpty()) {
            throw new \RuntimeException('No categories found. Please run category seeder first.');
        }

        $titles = [
            'Supermercado',
            'Restaurante',
            'Combustível',
            'Cinema',
            'Farmácia',
            'Uber',
            'Material de Escritório',
            'Internet',
            'Energia',
            'Água',
            'Netflix',
            'Amazon Prime',
            'Spotify',
            'Academia',
            'Roupas',
            'Manutenção Carro',
            'Presente',
            'Livros',
            'Jogos',
            'Hardware'
        ];

        for ($i = 0; $i < 50; $i++) {
            $date = Carbon::create(2024, 12, rand(1, 31), rand(0, 23), rand(0, 59), rand(0, 59));
            $amount = rand(1000, 100000) / 100; // Valores entre R$ 10,00 e R$ 1.000,00
            $title = $titles[array_rand($titles)];

            TransactionModel::create([
                'id' => Str::uuid()->toString(),
                'title' => $title,
                'amount' => $amount,
                'date_time' => $date,
                'category_id' => $categories->random()->id,
            ]);
        }
    }
}
