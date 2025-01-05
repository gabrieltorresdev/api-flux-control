<?php

namespace App\Core\Application\Category\DTO\Show;

use App\Core\Domain\Enum\CategoryType;
use App\Shared\ObjectAbstract;

class OutShowCategory extends ObjectAbstract
{
    public string $id;
    public string $userId;
    public string $name;
    public CategoryType $type;
    public ?string $icon;
    public bool $isDefault;
}
