<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Entity\User;

interface IUserRepository
{
    /** @return User[] */
    public function findAll(): array;

    public function findByKeycloakId(string $keycloakId): ?User;

    public function findByUsername(string $username): ?User;

    public function create(string $name, string $email, string $username, string $keycloakId): User;
}
