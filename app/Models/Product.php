<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'description',
        'sku',
        'price',
        'cost',
        'stock_quantity',
        'reorder_level',
        'created_by',
    ];

    public function category() : BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function creator() : BelongsTo {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function transactions() : HasMany {
        return $this->hasMany(InventoryTransaction::class);
    }

    public function updateStock($quantity, $totalValue)
    {
        $this->stock_quantity += $quantity;
        $this->price += $totalValue;
        $this->save();
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('created_by', $userId); 
    }

    public function scopeSearch($q, $search)
    {
        return $q->where('name', 'like', "%{$search}%")
        ->oRwhere('description', 'like', "%{$search}%")
        ->oRwhere('sku', 'like', "%{$search}%");
    }
}
