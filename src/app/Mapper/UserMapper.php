<?php

namespace App\Mapper;

use App\Core\Domain\Entity\User as Entity;
use App\Persistence\Eloquent\Model\UserModel as Model;

class UserMapper implements Mapper
{
    public static function fromArray(array|object $data): Entity
    {
        return self::fromEloquent(new Model($data));
    }

    public static function fromEloquent(Model $model): Entity
    {
        return new Entity(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            username: $model->username,
            keycloakId: $model->keycloak_id
        );
    }
}
