<?php

namespace App\Http\Requests;

use App\Core\Domain\Enum\CategoryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:categories,name'],
            'type' => ['required', 'string', Rule::enum(CategoryType::class)]
        ];
    }
}
