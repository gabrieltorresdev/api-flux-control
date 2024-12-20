<?php

namespace Database\Seeders;

use App\Core\Domain\Enum\TransactionCategoryType;
use App\Persistence\Eloquent\Model\TransactionCategoryModel;
use App\Persistence\Eloquent\Model\TransactionModel;
use App\Persistence\Eloquent\Model\UserModel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        UserModel::factory(5)->create();

        TransactionCategoryModel::create([
            'name' => 'Entrada',
            'type' => TransactionCategoryType::INCOME,
            'is_default' => true
        ]);

        TransactionCategoryModel::create([
            'name' => 'Saída',
            'type' => TransactionCategoryType::EXPENSE,
            'is_default' => true
        ]);
    }
}
