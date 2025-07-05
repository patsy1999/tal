<?php

// app/Models/ChlorineControl.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChlorineControl extends Model
{
    protected $fillable = [
        'date',
        'heure',
        'sampling_point',
        'chlorine_ppm_min',
        'chlorine_ppm_max',
        'conforme',
        'mesures_correctives',
];

}
