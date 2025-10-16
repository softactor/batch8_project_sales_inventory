<?php

namespace App\Http\Requests;

use App\Http\Requests\Auth\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class InventoryTransactionRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required',
            'type' => 'required',
            'quantity' => 'required',
            'unit_cost' => 'required',
            'total_value' => 'required',
            'notes' => 'required',
        ];
    }
}
