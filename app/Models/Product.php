<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function tookenItems()
{
    return $this->hasMany(TookenItem::class);
}
    protected $fillable = [
        'name',
        'type', // electric, mechanic, etc.
        'quantity',
        'prix'
    ];
}
