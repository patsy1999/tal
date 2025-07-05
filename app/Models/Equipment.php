<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipment'; // ✅ the actual table in your database
    protected $fillable = ['name'];
}
