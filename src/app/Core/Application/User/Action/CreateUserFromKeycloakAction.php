<?php

namespace App\Core\Application\User\Action;

use App\Core\Domain\Entity\User;
use App\Core\Domain\Repository\IUserRepository;

readonly class CreateUserFromKeycloakAction
{
    public function __construct(private IUserRepository $repository) {}

    public function execute(
        string $name,
        string $email,
        string $username,
        string $keycloakId
    ): User {
        return $this->repository->create(
            name: $name,
            email: $email,
            username: $username,
            keycloakId: $keycloakId
        );
    }
}
