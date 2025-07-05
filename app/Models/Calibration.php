<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calibration extends Model
{
    use HasFactory;

    protected $fillable = [
        'instrument_id',
        'calibration_date',
        'verified',
        'conform',
        'comment',
        'signature',
    ];

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }
    protected $casts = [
    'calibration_date' => 'date',  // or 'datetime' if time is included
];

}
