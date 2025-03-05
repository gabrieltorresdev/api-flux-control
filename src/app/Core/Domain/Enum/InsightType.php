<?php

namespace App\Core\Domain\Enum;

enum InsightType: string
{
    case SUCCESS = 'success';
    case WARNING = 'warning';
    case INFO = 'info';
    case DANGER = 'danger';
} 