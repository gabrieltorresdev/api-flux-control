<?php

namespace App\Core\Application\Category\Action;

use App\Core\Application\Category\DTO\List\InListCategories;
use App\Core\Application\Category\DTO\List\OutListCategory;
use App\Core\Domain\Repository\ICategoryRepository;

readonly class ListCategoriesAction
{
    public function __construct(
        private ICategoryRepository $categoryRepository
    ) {}

    /** @return OutListCategory[] */
    public function execute(InListCategories $data): array
    {
        return OutListCategory::arrayOf($this->categoryRepository->index($data->userId, $data->name, $data->type));
    }
}
