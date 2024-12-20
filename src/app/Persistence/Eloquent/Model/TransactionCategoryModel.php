<?php

namespace App\Persistence\Eloquent\Model;

use App\Core\Domain\Enum\TransactionCategoryType;
use Database\Factories\TransactionCategoryFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionCategoryModel extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'transactions_categories';
    protected $guarded = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'type' => TransactionCategoryType::class,
        'is_default' => 'boolean',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(TransactionModel::class, 'category_id');
    }

    protected static function newFactory(): Factory
    {
        return TransactionCategoryFactory::new();
    }
}
