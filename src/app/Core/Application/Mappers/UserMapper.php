<?php

namespace Core\Application\Mappers;

use App\Persistence\Eloquent\Models\UserModel as Model;
use Core\Domain\Entities\User;

class UserMapper
{
    public static function fromArray(array|object $dados): User
    {
        return self::fromEloquent(new Model($dados));
    }

    public static function fromEloquent(Model $model): User
    {
        return new User(
            id: $model->id,
            name: $model->name,
            email: $model->email
        );
    }
}
