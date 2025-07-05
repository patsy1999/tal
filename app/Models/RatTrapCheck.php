<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatTrapCheck extends Model
{
    protected $fillable = [
        'check_date', 'trap_number', 'bait_touched', 'corpse_present', 'action_taken'
    ];
}
