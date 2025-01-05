<?php

namespace App\Persistence\Eloquent\Model;

use App\Core\Domain\Enum\CategoryType;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryModel extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'categories';
    protected $guarded = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'type' => CategoryType::class,
        'is_default' => 'boolean',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(TransactionModel::class, 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    protected static function newFactory(): Factory
    {
        return CategoryFactory::new();
    }
}
