<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentListSeeder extends Seeder
{
    public function run(): void
    {
        $equipmentList = [
            "Tapis de ligne 1", "Thermo-soudure 1", "Etiqueteuses barquette 1", "Imprimante 1 L1", "Imprimante 2 L1", "Machine contrôle du poids 1", "Détecteur de métal 1", "Etiqueteuse carton 1",
            "Tapis de ligne 2", "Thermo-soudure 2", "Etiqueteuses barquette 2", "Imprimante 1 L2", "Imprimante 2 L2", "Machine contrôle du poids 2", "Détecteur de métal 2", "Etiqueteuse carton 2",
            "Tapis de ligne 3", "Thermo-soudure 3", "Etiqueteuses barquette 3", "Imprimante 1 L3", "Imprimante 2 L3", "Machine contrôle du poids 3", "Détecteur de métal 3", "Etiqueteuse carton 3",
            "Tapis de ligne 4", "Thermo-soudure 4", "Etiqueteuses barquette 4", "Imprimante 1 L4", "Imprimante 2 L4", "Machine contrôle du poids 4", "Détecteur de métal 4", "Etiqueteuse carton 4",
            "Tapis de ligne 5", "Thermo-soudure 5", "Etiqueteuses barquette 5", "Imprimante 1 L5", "Imprimante 2 L5", "Machine contrôle du poids 5", "Détecteur de métal 5", "Etiqueteuse carton 5",
            "Tapis de ligne 6", "Thermo-soudure 6", "Etiqueteuses barquette 6", "Imprimante 1 L6", "Imprimante 2 L6", "Détecteur de métal 6", "Etiqueteuse carton 6",
            "Chambre froide 1", "Chambre froide 2", "Chambre froide 3", "Chambre froide 4", "Chambre froide 5", "Chambre froide 6", "Chambre froide 7", "Chambre froide 8",
            "Tunnel 1", "Tunnel 2", "Tunnel 3", "Tunnel 4", "Tunnel 5", "Tunnel 6", "Tunnel 7", "Tunnel 8", "Tunnel 9", "Tunnel 10",
            "Salle manipulation 1", "Salle manipulation 2",
            "Centrale frigorifique 1", "Centrale frigorifique 2", "Centrale frigorifique 3",
            "Compresseur frigorifique 1", "Compresseur frigorifique 2", "Compresseur frigorifique 3", "Compresseur frigorifique 4",
            "Evaporateurs", "Régulateurs de température et sondes",
            "Réfrigérateur 1", "Réfrigérateur 2", "Réfrigérateur 3",
            "Laboratoire 1", "Laboratoire 2",
            "TGBT 1", "TGBT 2", "Poste de transformation MT/BT",
            "Les pompes d’eau", "Refractomètres et thermomètre", "Photomètre",
            "Pompe doseuse chlore", "Caméras de surveillance",
            "Les portes de secours", "Système de détection l’incendie", "Les pointes d’accès TOP CONTROLE",
            "Les pointeuse", "Eclairages", "Balances", "Moustiquaires", "Transpalettes",
            "Aération de la station", "Armoires de commande", "Portes d’accès",
            "Les chemins de câble", "Machine cerclage"
        ];

        foreach ($equipmentList as $name) {
            DB::table('equipment')->updateOrInsert(
                ['name' => $name],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
