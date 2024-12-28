<?php

namespace App\Core\Application\Category\DTO\Update;

use App\Core\Domain\Enum\CategoryType;
use App\Shared\ObjectAbstract;

class OutUpdateCategory extends ObjectAbstract
{
    public string $id;
    public string $name;
    public CategoryType $type;
    public bool $is_default;
}
