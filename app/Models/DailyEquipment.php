<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyEquipment extends Model
{
    protected $table = 'daily_equipments';  // ✅ Add this line
    protected $fillable = ['date', 'equipment_name', 'is_good', 'observation'];

}
