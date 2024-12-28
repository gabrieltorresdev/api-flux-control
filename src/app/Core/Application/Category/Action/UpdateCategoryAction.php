<?php

namespace App\Core\Application\Category\Action;

use App\Core\Application\Category\DTO\Update\InUpdateCategory;
use App\Core\Application\Category\DTO\Update\OutUpdateCategory;
use App\Core\Domain\Repository\ICategoryRepository;

readonly class UpdateCategoryAction
{
    public function __construct(
        private ICategoryRepository $categoryRepository
    ) {}

    public function execute(InUpdateCategory $data): OutUpdateCategory
    {
        return OutUpdateCategory::from(
            $this->categoryRepository->update(
                $data->id,
                $data->name,
                $data->type,
                $data->icon
            )
        );
    }
}
