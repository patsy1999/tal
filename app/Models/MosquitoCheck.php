<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MosquitoCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'month',
        'D01', 'D02', 'D03', 'D04', 'D05',
        'D06', 'D07', 'D08', 'D09', 'D10',
        'D11', 'D12', 'D13', 'D14', 'D15',
        'moustiquaire',
        'etat_nettoyage',
        'action_corrective'
    ];

    protected $dates = ['date'];
}
