<?php

namespace App\Persistence\Eloquent\Model;

use App\Core\Domain\Enum\TransactionCategoryType;
use Database\Factories\TransactionCategoryFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionCategoryModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'transactions_categories';
    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'type' => TransactionCategoryType::class,
    ];

    protected static function newFactory(): Factory
    {
        return TransactionCategoryFactory::new();
    }
}
