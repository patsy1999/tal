<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MechanicalTrapCheck extends Model
{
    protected $fillable = ['check_date', 'trap_code', 'captures', 'action_taken'];
}

