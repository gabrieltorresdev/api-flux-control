<?php

namespace App\Core\Domain\Enum;

enum TransactionCategoryType: string {
    case EXPENSE = 'expense';
    case INCOME = 'income';
}
