<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Entity\User;
use App\Core\Domain\Enum\UserStatus;

interface IUserRepository
{
    /** @return User[] */
    public function findAll(): array;

    public function findById(string $id): ?User;

    public function findByKeycloakId(string $keycloakId): ?User;

    public function findByUsername(string $username): ?User;

    public function create(
        string $name,
        string $email,
        string $username,
        string $keycloakId,
        UserStatus $status
    ): User;

    public function update(User $user): void;
}
