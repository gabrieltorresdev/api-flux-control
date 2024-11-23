<?php

namespace App\Persistence\Eloquent\Model;

use App\Core\Domain\Enum\TransactionType;
use Database\Factories\TransactionFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'transactions';
    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'type' => TransactionType::class,
    ];

    protected static function newFactory(): Factory
    {
        return TransactionFactory::new();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TransactionCategoryModel::class);
    }
}