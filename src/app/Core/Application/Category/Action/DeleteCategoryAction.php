<?php

namespace App\Core\Application\Category\Action;

use App\Core\Domain\Repository\ICategoryRepository;

readonly class DeleteCategoryAction
{
    public function __construct(
        private ICategoryRepository $categoryRepository
    ) {}

    public function execute(string $id): void
    {
        $this->categoryRepository->delete($id);
    }
}
