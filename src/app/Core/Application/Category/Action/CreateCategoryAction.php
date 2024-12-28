<?php

namespace App\Core\Application\Category\Action;

use App\Core\Application\Category\DTO\Create\InCreateCategory;
use App\Core\Application\Category\DTO\Create\OutCreateCategory;
use App\Core\Domain\Repository\ICategoryRepository;

readonly class CreateCategoryAction
{
    public function __construct(
        private ICategoryRepository $categoryRepository
    ) {}

    public function execute(InCreateCategory $data): OutCreateCategory
    {
        return OutCreateCategory::from($this->categoryRepository->create(
            $data->name,
            $data->type
        ));
    }
}
