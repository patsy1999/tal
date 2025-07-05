<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TookenItem extends Model
{
    public function user()
{
    return $this->belongsTo(User::class);
}

public function product()
{
    return $this->belongsTo(Product::class);
}
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'reason',
        'taken_at',
    ];
    protected $casts = [
    'taken_at' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];

}
