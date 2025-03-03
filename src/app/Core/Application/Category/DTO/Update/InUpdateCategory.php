<?php

namespace App\Core\Application\Category\DTO\Update;

use App\Core\Domain\Enum\CategoryType;
use App\Shared\ObjectAbstract;

class InUpdateCategory extends ObjectAbstract
{
    public string $id;
    public string $userId;
    public string $name;
    public CategoryType $type;
    public string $icon;
}
