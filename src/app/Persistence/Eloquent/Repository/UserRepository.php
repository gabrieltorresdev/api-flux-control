<?php

namespace App\Persistence\Eloquent\Repository;

use App\Core\Domain\Repository\IUserRepository;
use App\Mapper\UserMapper;
use App\Persistence\Eloquent\Model\UserModel as Model;

readonly class UserRepository implements IUserRepository
{
    public function __construct(private Model $model)
    {}

    public function findAll(): array
    {
        return $this->model
            ->all()
            ->map(fn($user) => UserMapper::fromEloquent($user))
            ->toArray();
    }
}
