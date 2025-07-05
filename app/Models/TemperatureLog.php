<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemperatureLog extends Model
{
    protected $fillable = ['user_id', 'date', 'location', 'time_slot', 'vl', 'vm'];
}
