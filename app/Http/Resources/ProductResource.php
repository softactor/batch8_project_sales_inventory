<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'sku' => $this->sku,
            'cost' => $this->cost,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            'reorder_level' => $this->reorder_level,
            'created_by_id' => $this->creator->id,
            'created_by_name' => $this->creator->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

    }
}
