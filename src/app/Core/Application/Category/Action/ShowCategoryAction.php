<?php

namespace App\Core\Application\Category\Action;

use App\Core\Application\Category\DTO\Show\OutShowCategory;
use App\Core\Domain\Repository\ICategoryRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class ShowCategoryAction
{
    public function __construct(
        private ICategoryRepository $categoryRepository
    ) {}

    public function execute(string $name): OutShowCategory
    {
        $result = $this->categoryRepository->findByName($name);

        if (!$result) {
            throw new NotFoundHttpException('Category not found!');
        }

        return OutShowCategory::from($result);
    }
}
