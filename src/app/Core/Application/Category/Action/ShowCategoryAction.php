<?php

namespace App\Core\Application\Category\Action;

use App\Core\Application\Category\DTO\Show\InShowCategory;
use App\Core\Application\Category\DTO\Show\OutShowCategory;
use App\Core\Domain\Repository\ICategoryRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class ShowCategoryAction
{
    public function __construct(
        private ICategoryRepository $categoryRepository
    ) {}

    public function execute(InShowCategory $input): OutShowCategory
    {
        $result = $this->categoryRepository->findById($input->userId, $input->id);

        if (!$result) {
            throw new NotFoundHttpException('Category not found!');
        }

        return OutShowCategory::from($result);
    }
}
