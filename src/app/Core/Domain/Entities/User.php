<?php

namespace Core\Domain\Entities;

class User extends Entity
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email
    ) {
    }
}
