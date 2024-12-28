<?php

namespace App\Http\Requests;

use App\Core\Domain\Enum\CategoryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique('categories', 'name')->ignore($this->route('id'))],
            'type' => ['required', 'string', Rule::enum(CategoryType::class)]
        ];
    }
}