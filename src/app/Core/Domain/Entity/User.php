<?php

namespace App\Core\Domain\Entity;

use App\Core\Domain\Enum\UserStatus;

class User extends Entity
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $username,
        public ?string $keycloakId = null,
        public UserStatus $status = UserStatus::PENDING
    ) {}
}
