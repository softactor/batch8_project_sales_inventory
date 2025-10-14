<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];


    protected  $casts = [
        'is_active' => 'boolean'
    ]; 

    public function permissions() : BelongsToMany 
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }
}
