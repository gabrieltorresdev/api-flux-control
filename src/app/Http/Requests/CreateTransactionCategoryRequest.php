<?php

namespace App\Http\Requests;

use App\Core\Domain\Enum\TransactionCategoryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTransactionCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:transactions_categories,name'],
            'type' => ['required', 'string', Rule::enum(TransactionCategoryType::class)]
        ];
    }
}
