<?php

namespace App\Persistence\Eloquent\Repository;

use App\Core\Domain\Entity\TransactionCategory;
use App\Core\Domain\Enum\TransactionCategoryType;
use App\Core\Domain\Repository\ITransactionCategoryRepository;
use App\Mapper\TransactionCategoryMapper;
use App\Persistence\Eloquent\Model\TransactionCategoryModel as Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class TransactionCategoryRepository implements ITransactionCategoryRepository
{
    public function __construct(private Model $model) {}

    public function index(?string $name, ?TransactionCategoryType $type): array
    {
        return $this->model::query()
            ->when($name, function ($query) use ($name) {
                $query->where('name', 'like', "%$name%");
            })
            ->when($type, function ($query) use ($type) {
                $query->where('type', '=', "$type->value");
            })
            ->orderBy('is_default', 'desc')
            ->orderBy('type', 'asc')
            ->orderBy('name', 'asc')
            ->get()
            ->map(fn($item) => TransactionCategoryMapper::fromEloquent($item))
            ->toArray();
    }

    public function create(string $name, TransactionCategoryType $type): TransactionCategory
    {
        $result = $this->model::query()->create(compact(['name', 'type']));

        return TransactionCategoryMapper::fromEloquent($result);
    }

    public function findByName(string $name): ?TransactionCategory
    {
        $result = $this->model::query()
            ->where('name', '=', $name)
            ->first();

        return $result ? TransactionCategoryMapper::fromEloquent($result) : null;
    }

    public function delete(string $id): void
    {
        $category = $this->model::query()->findOrFail($id);

        if ($category->is_default) {
            throw new \RuntimeException('Cannot delete default categories');
        }

        $defaultCategory = $this->model::query()
            ->where('type', $category->type)
            ->where('is_default', true)
            ->first();

        if (!$defaultCategory) {
            throw new \RuntimeException('Default category not found');
        }

        DB::transaction(function () use ($category, $defaultCategory) {
            $category->transactions()->update(['category_id' => $defaultCategory->id]);
            $category->delete();
        });
    }

    public function update(string $id, string $name, TransactionCategoryType $type): TransactionCategory
    {
        $result = $this->model::query()->find($id);

        if (!$result) {
            throw new NotFoundHttpException('Transaction Category not found!');
        }

        $result->update(compact('name', 'type'));

        return TransactionCategoryMapper::fromEloquent($result);
    }
}
