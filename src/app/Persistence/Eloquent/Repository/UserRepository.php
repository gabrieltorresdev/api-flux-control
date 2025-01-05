<?php

namespace App\Persistence\Eloquent\Repository;

use App\Core\Domain\Entity\User;
use App\Core\Domain\Repository\IUserRepository;
use App\Mapper\UserMapper;
use App\Persistence\Eloquent\Model\UserModel as Model;

readonly class UserRepository implements IUserRepository
{
    public function __construct(private Model $model) {}

    public function findAll(): array
    {
        return $this->model
            ->all()
            ->map(fn($user) => UserMapper::fromEloquent($user))
            ->toArray();
    }

    public function findByKeycloakId(string $keycloakId): ?User
    {
        $user = $this->model->where('keycloak_id', $keycloakId)->first();
        return $user ? UserMapper::fromEloquent($user) : null;
    }

    public function findByUsername(string $username): ?User
    {
        $user = $this->model->where('username', $username)->first();
        return $user ? UserMapper::fromEloquent($user) : null;
    }

    public function create(string $name, string $email, string $username, string $keycloakId): User
    {
        $user = $this->model->create([
            'name' => $name,
            'email' => $email,
            'username' => $username,
            'keycloak_id' => $keycloakId,
        ]);

        return UserMapper::fromEloquent($user);
    }
}
