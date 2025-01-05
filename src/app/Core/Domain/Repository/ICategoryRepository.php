<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Entity\Category;
use App\Core\Domain\Enum\CategoryType;

interface ICategoryRepository
{
    /** @return Category[] */
    public function index(string $userId, ?string $name, ?CategoryType $type): array;
    public function create(string $userId, string $name, CategoryType $type, ?string $icon): Category;
    public function createDefault(string $userId, string $name, CategoryType $type): Category;
    public function findByName(string $userId, string $name): ?Category;
    public function delete(string $userId, string $id): void;
    public function update(string $userId, string $id, string $name, CategoryType $type, string $icon): Category;
}
