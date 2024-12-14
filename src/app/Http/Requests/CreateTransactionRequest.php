<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categoryId' => ['required', 'uuid', 'exists:transactions_categories,id'],
            'title' => ['string', 'max:255'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'dateTime' => ['required', 'date', 'before_or_equal:today'],
        ];
    }
}
