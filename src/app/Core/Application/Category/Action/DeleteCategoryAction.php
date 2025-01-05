<?php

namespace App\Core\Application\Category\Action;

use App\Core\Application\Category\DTO\Delete\InDeleteCategory;
use App\Core\Domain\Repository\ICategoryRepository;

readonly class DeleteCategoryAction
{
    public function __construct(
        private ICategoryRepository $categoryRepository
    ) {}

    public function execute(InDeleteCategory $data): void
    {
        $this->categoryRepository->delete($data->userId, $data->id);
    }
}
