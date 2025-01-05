<?php

namespace App\Core\Application\Category\DTO\Create;

use App\Core\Domain\Enum\CategoryType;
use App\Shared\ObjectAbstract;

class InCreateCategory extends ObjectAbstract
{
    public string $userId;
    public string $name;
    public CategoryType $type;
    public ?string $icon;
}
