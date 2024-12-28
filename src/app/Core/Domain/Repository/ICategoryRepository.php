<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Entity\Category;
use App\Core\Domain\Enum\CategoryType;

interface ICategoryRepository
{
    /** @return Category[] */
    public function index(?string $name, ?CategoryType $type): array;
    public function create(string $name, CategoryType $type): Category;
    public function findByName(string $name): ?Category;
    public function delete(string $id): void;
    public function update(string $id, string $name, CategoryType $type): Category;
}
