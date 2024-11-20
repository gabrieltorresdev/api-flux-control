<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Entity\User;

interface IUserRepository
{
    /** @return User[] */
    public function findAll(): array;
}
