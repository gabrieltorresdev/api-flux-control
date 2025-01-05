<?php

namespace App\Persistence\Eloquent\Repository;

use App\Core\Domain\Entity\Category;
use App\Core\Domain\Enum\CategoryType;
use App\Core\Domain\Repository\ICategoryRepository;
use App\Mapper\CategoryMapper;
use App\Persistence\Eloquent\Model\CategoryModel as Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class CategoryRepository implements ICategoryRepository
{
    public function __construct(private Model $model) {}

    public function index(string $userId, ?string $name, ?CategoryType $type): array
    {
        return $this->model::query()
            ->where('user_id', $userId)
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
            ->map(fn($item) => CategoryMapper::fromEloquent($item))
            ->toArray();
    }

    public function create(string $userId, string $name, CategoryType $type, ?string $icon): Category
    {
        $result = $this->model::query()->create([
            'user_id' => $userId,
            'name' => $name,
            'type' => $type,
            'icon' => $icon,
            'is_default' => false
        ]);

        return CategoryMapper::fromEloquent($result);
    }

    public function createDefault(string $userId, string $name, CategoryType $type): Category
    {
        $result = $this->model::query()->create([
            'user_id' => $userId,
            'name' => $name,
            'type' => $type,
            'icon' => null,
            'is_default' => true
        ]);

        return CategoryMapper::fromEloquent($result);
    }

    public function findByName(string $userId, string $name): ?Category
    {
        $result = $this->model::query()
            ->where('user_id', $userId)
            ->where('name', '=', $name)
            ->first();

        return $result ? CategoryMapper::fromEloquent($result) : null;
    }

    public function delete(string $userId, string $id): void
    {
        $category = $this->model::query()
            ->where('user_id', $userId)
            ->findOrFail($id);

        if ($category->is_default) {
            throw new \RuntimeException('Cannot delete default categories');
        }

        $defaultCategory = $this->model::query()
            ->where('user_id', $userId)
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

    public function update(string $userId, string $id, string $name, CategoryType $type, string $icon): Category
    {
        $result = $this->model::query()
            ->where('user_id', $userId)
            ->find($id);

        if (!$result) {
            throw new NotFoundHttpException('Category not found!');
        }

        $result->update(compact('name', 'type', 'icon'));

        return CategoryMapper::fromEloquent($result);
    }
}
