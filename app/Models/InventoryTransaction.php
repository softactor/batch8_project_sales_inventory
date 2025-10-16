<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryTransaction extends Model
{
    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'unit_cost',
        'total_value',
        'notes',
        'created_by',
    ];

    public function product() : BelongsTo {
        return $this->belongsTo(Product::class);
    }

    public function creator() : BelongsTo {
        return $this->belongsTo(User::class, 'created_by');
    }
}
