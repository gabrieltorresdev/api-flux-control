<?php

namespace App\Core\Domain\Entity;

use App\Core\Domain\Enum\CategoryType;

class Category extends Entity
{
    public User $user;
    public function __construct(
        public string $id,
        public string $name,
        public CategoryType $type,
        public ?string $icon = null,
        public bool $isDefault = false
    ) {}

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
