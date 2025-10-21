<?php

namespace App\Http\Requests;

use App\Http\Requests\Auth\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryUpdateRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $categoryId = $this->route('category');
        return [
            'name' => ['required',
                Rule::unique('categories')->ignore($categoryId)
            ],
            'description' => 'required'
        ];
    }
}
