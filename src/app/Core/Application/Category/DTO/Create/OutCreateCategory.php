<?php

namespace App\Core\Application\Category\DTO\Create;

use App\Core\Domain\Enum\CategoryType;
use App\Shared\ObjectAbstract;

class OutCreateCategory extends ObjectAbstract
{
    public string $id;
    public string $name;
    public CategoryType $type;
}
