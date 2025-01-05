<?php

namespace App\Core\Domain\Enum;

enum UserStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
}
