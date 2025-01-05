<?php

namespace App\Core\Application\Category\Action;

use App\Core\Application\Category\DTO\Show\InGetCategoryByName;
use App\Core\Application\Category\DTO\Show\OutShowCategory;
use App\Core\Domain\Repository\ICategoryRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class GetCategoryByNameAction
{
    public function __construct(
        private ICategoryRepository $categoryRepository
    ) {}

    public function execute(InGetCategoryByName $data): OutShowCategory
    {
        $result = $this->categoryRepository->findByName($data->userId, $data->name);

        if (!$result) {
            throw new NotFoundHttpException('Category not found!');
        }

        return OutShowCategory::from($result);
    }
}
