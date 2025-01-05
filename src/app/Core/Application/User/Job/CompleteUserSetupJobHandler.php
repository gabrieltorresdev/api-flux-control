<?php

namespace App\Core\Application\User\Job;

use App\Core\Domain\Repository\IUserRepository;
use App\Core\Domain\Repository\ICategoryRepository;
use App\Core\Domain\Enum\UserStatus;
use App\Core\Domain\Enum\CategoryType;

readonly class CompleteUserSetupJobHandler
{
    public function __construct(
        private IUserRepository $userRepository,
        private ICategoryRepository $categoryRepository
    ) {}

    public function execute(string $userId): void
    {
        try {
            $user = $this->userRepository->findById($userId);

            // Criar categorias padrão
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

            // Atualizar status do usuário para completed
            $user->status = UserStatus::COMPLETED;
            $this->userRepository->update($user);
        } catch (\Throwable $e) {
            // Em caso de erro, marcar usuário como failed
            $user = $this->userRepository->findById($userId);
            $user->status = UserStatus::FAILED;
            $this->userRepository->update($user);

            throw $e;
        }
    }
}
