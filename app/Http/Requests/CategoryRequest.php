<?php

namespace App\Http\Requests;

use App\Http\Requests\Auth\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends BaseRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required'
        ];
    }
}
