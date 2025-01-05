<?php

namespace App\Persistence\Eloquent\Repository;

use App\Core\Domain\Entity\User;
use App\Core\Domain\Repository\IUserRepository;
use App\Core\Domain\Enum\UserStatus;
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

    public function findById(string $id): ?User
    {
        $user = $this->model->find($id);
        return $user ? UserMapper::fromEloquent($user) : null;
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

    public function create(
        string $name,
        string $email,
        string $username,
        string $keycloakId,
        UserStatus $status
    ): User {
        $user = $this->model->create([
            'name' => $name,
            'email' => $email,
            'username' => $username,
            'keycloak_id' => $keycloakId,
            'status' => $status->value
        ]);

        return UserMapper::fromEloquent($user);
    }

    public function update(User $user): void
    {
        $this->model->where('id', $user->id)->update([
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->username,
            'keycloak_id' => $user->keycloakId,
            'status' => $user->status->value
        ]);
    }
}
