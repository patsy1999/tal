<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceIntervention extends Model
{
    protected $fillable = [
    'date',
    'start_time',
    'end_time',
    'zone',
    'company',
    'intervenant',
    'work_details',
    'materials_used',
    'site_clean',
    'production_ongoing',
    'cleaning_end_time',
    'risk_level',
    'product_safety_risk',
    'risk_description',
    'location_signed',
    'date_signed',
];

}
