<?php

namespace App\Http\Requests;

use App\Core\Domain\Enum\TransactionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'uuid', 'exists:transactions_categories,id'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'date' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'type' => ['required', 'string', Rule::enum(TransactionType::class)],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
