<?php

namespace App\Core\Application\Category\DTO\List;

use App\Core\Domain\Enum\CategoryType;
use App\Shared\ObjectAbstract;

class InListCategories extends ObjectAbstract
{
    public ?string $name;
    public ?CategoryType $type;
}
