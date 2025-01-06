<?php

namespace App\Core\Application\User\Action;

use App\Core\Domain\Repository\IUserRepository;
use App\Core\Domain\Enum\UserStatus;

readonly class GetUserStatusAction
{
    public function __construct(
        private IUserRepository $repository
    ) {}

    public function execute(string $userId): string
    {
        $user = $this->repository->findById($userId);
        return $user?->status->value ?? UserStatus::FAILED->value;
    }
}
