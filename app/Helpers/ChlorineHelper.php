<?php

namespace App\Helpers;

class ChlorineHelper
{
    public static function getChlorineClass($entry)
    {
        if ($entry->heure === '09:00') {
            return $entry->chlorine_ppm_min < 0.3 ? 'text-danger' :
                  ($entry->chlorine_ppm_min > 2.0 ? 'text-warning' : 'text-success');
        }

        if ($entry->heure === '14:00') {
            return $entry->chlorine_ppm_max < 0.3 ? 'text-danger' :
                  ($entry->chlorine_ppm_max > 2.0 ? 'text-warning' : 'text-success');
        }

        return 'text-secondary';
    }
}
