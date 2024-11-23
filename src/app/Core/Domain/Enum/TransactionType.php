<?php

namespace App\Core\Domain\Enum;

enum TransactionType: string {
    case EXPENSE = 'expense';
    case INCOME = 'income';
}
