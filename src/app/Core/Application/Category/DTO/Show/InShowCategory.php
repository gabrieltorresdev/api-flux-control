<?php

namespace App\Core\Application\Category\DTO\Show;

use Spatie\LaravelData\Data;

class InShowCategory extends Data
{
    public function __construct(
        public readonly string $userId,
        public readonly string $id,
    ) {}
}
