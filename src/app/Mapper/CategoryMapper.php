<?php

namespace App\Mapper;

use App\Core\Domain\Entity\Category as Entity;
use App\Persistence\Eloquent\Model\CategoryModel as Model;

class CategoryMapper implements Mapper
{
    public static function fromArray(array|object $data): Entity
    {
        return self::fromEloquent(new Model($data));
    }

    public static function fromEloquent(Model $model): Entity
    {
        $entity = new Entity(
            id: $model->id,
            name: $model->name,
            type: $model->type,
            icon: $model->icon,
            isDefault: $model->is_default ?? false
        );

        if ($model->relationLoaded('user')) {
            $entity->setUser(UserMapper::fromEloquent($model->user));
        }

        return $entity;
    }
}
