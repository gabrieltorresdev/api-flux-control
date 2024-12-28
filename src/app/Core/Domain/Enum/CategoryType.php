<?php

namespace App\Core\Domain\Enum;

enum CategoryType: string
{
    case EXPENSE = 'expense';
    case INCOME = 'income';
}
