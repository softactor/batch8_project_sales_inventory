<?php

namespace App\Http\Requests;

use App\Http\Requests\Auth\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends BaseRequest
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
            'category_id' => 'required',
            'description' => 'required',
            'sku' => 'required|unique:products,sku',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
            'cost' => 'required',
            'price' => 'required',
            'stock_quantity' => 'required',
            'reorder_level' => 'required',
        ];
    }
}
