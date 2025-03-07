<?php

namespace App\Core\Application\Category\DTO\List;

use App\Core\Domain\Enum\CategoryType;
use App\Shared\ObjectAbstract;

class OutListCategory extends ObjectAbstract
{
    public string $id;
    public string $name;
    public ?string $icon;
    public CategoryType $type;
    public bool $isDefault;
}
