<?php

namespace Database\Seeders;

use App\Core\Domain\Enum\CategoryType;
use App\Persistence\Eloquent\Model\CategoryModel;
use App\Persistence\Eloquent\Model\TransactionModel;
use App\Persistence\Eloquent\Model\UserModel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        UserModel::factory(5)->create();

        CategoryModel::create([
            'name' => 'Entrada',
            'type' => CategoryType::INCOME,
            'is_default' => true
        ]);

        CategoryModel::create([
            'name' => 'Saída',
            'type' => CategoryType::EXPENSE,
            'is_default' => true
        ]);
    }
}
