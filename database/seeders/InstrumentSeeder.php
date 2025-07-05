<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Instrument;


class InstrumentSeeder extends Seeder
{
    public function run()
    {
        $instruments = [
            "Thermomètre 1",
            "Thermomètre 2",
            "Thermomètre 3",
            "Thermomètre 4",
            "Thermomètre 5",
            "Thermomètre 6",
            "Thermomètre 7",
            "Thermomètre 8",
            "Thermomètre 9",
            "Thermomètre 10",
            "Thermomètre 11",
            "Thermomètre 12",
            "Photomètre du chlore",
            "Sonde I zone de réception",
            "Sonde I Chambre froide 1",
            "Sonde II Chambre froide 2",
            "Sonde III Chambre froide3",
            "Sonde IV Chambre froide4",
            "Sonde V Chambre froide 5",
            "Sonde VI Chambre froide 6",
            "Sonde VII Chambre froide 7",
            "Sonde VIII Chambre froide 8",
            "Sonde I zone Manipulation",
            "Sonde I Tunnel 1",
            "Sonde II Tunnel 2",
            "Sonde III Tunnel 3",
            "Sonde IV Tunnel 4",
            "Sonde V Tunnel 5",
            "Sonde VI Tunnel 6",
            "Sonde VII Tunnel 7",
            "Sonde VIII Tunnel 8",
            "Sonde IX Tunnel 9",
            "Sonde X Tunnel 10",
            "Sonde I et II chambres froides de conservation",
            "Sonde réfrigérateur laboratoire 1 et 2",
            "Sonde réfrigérateur réfectoire",
        ];

        foreach ($instruments as $name) {
            Instrument::create(['name' => $name]);
        }
    }
}
