<?php

namespace App\Persistence\Eloquent\Repositories;

use App\Persistence\Eloquent\Models\UserModel;
use Core\Application\Mappers\UserMapper;
use Core\Domain\Repositories\UserRepositoryInterface;

readonly class UserRepository implements UserRepositoryInterface
{
    public function __construct(private UserModel $model)
    {}

    public function listar(): array
    {
        $user = $this->model->all();

        return $user->map(function ($projeto) {
            return UserMapper::fromEloquent($projeto);
        })->toArray();
    }
}
