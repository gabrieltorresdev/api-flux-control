<?php

namespace App\Core\Domain\Entity;

class User extends Entity
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $username,
        public ?string $keycloakId = null
    ) {}
}
