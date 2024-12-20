<?php

namespace App\Http\Requests;

use App\Core\Domain\Enum\TransactionCategoryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTransactionCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique('transactions_categories', 'name')->ignore($this->route('id'))],
            'type' => ['required', 'string', Rule::enum(TransactionCategoryType::class)]
        ];
    }
}
