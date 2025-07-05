<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockUsage extends Model
{
    protected $fillable = [
        'date',
        'used_quantity',
        'stock_quantity',
    ];

    public $timestamps = true; // Optional, since your migration includes timestamps
}
