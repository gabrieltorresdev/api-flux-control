<?php

namespace App\Core\Application\User\Action;

use App\Core\Domain\Entity\User;
use App\Core\Domain\Enum\CategoryType;
use App\Core\Domain\Repository\ICategoryRepository;
use App\Core\Domain\Repository\IUserRepository;

readonly class CreateUserFromKeycloakAction
{
    public function __construct(
        private IUserRepository $repository,
        private ICategoryRepository $categoryRepository
    ) {}

    public function execute(
        string $name,
        string $email,
        string $username,
        string $keycloakId
    ): User {
        $user = $this->repository->create(
            name: $name,
            email: $email,
            username: $username,
            keycloakId: $keycloakId
        );

        $this->createDefaultCategories($user->id);

        return $user;
    }

    private function createDefaultCategories(string $userId): void
    {
        $this->categoryRepository->createDefault(
            userId: $userId,
            name: 'Entrada',
            type: CategoryType::INCOME
        );

        $this->categoryRepository->createDefault(
            userId: $userId,
            name: 'Saída',
            type: CategoryType::EXPENSE
        );
    }
}
