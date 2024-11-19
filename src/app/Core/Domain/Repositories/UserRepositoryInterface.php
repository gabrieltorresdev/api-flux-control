<?php

namespace Core\Domain\Repositories;

use Core\Domain\Entities\User;

interface UserRepositoryInterface
{
    /** @return User[] */
    public function listar(): array;
}
