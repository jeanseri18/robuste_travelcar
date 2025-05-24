<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Societe;
use App\Models\Gare;
use App\Models\Lieu;
use App\Models\DestinationNational;
use App\Models\DestinationSousRegion;

class AfricaTravelTestDataSeeder extends Seeder
{
    public function run()
    {
        // Create Transport Companies
        $societes = [
            [
                'nom_commercial' => 'Sotra Transport',
                'description' => 'Principales lignes de transport en Côte d\'Ivoire',
            ],
            [
                'nom_commercial' => 'UTB',
                'description' => 'Union des Transports de Bouaké',
            ],
            [
                'nom_commercial' => 'Transport Intercités',
                'description' => 'Lignes de transport inter-régionales',
            ]
        ];

        $createdSocietes = [];
        foreach ($societes as $societeData) {
            $societe = Societe::create($societeData);
            $createdSocietes[] = $societe;
        }

        // Create Stations (Gares)
        $gares = [
            [
                'societe_id' => $createdSocietes[0]->id,
                'nom_gare' => 'Gare Principale Abidjan',
                'ville' => 'Abidjan',
                'adresse' => 'Plateau, Abidjan',
                'est_actif' => true
            ],
            [
                'societe_id' => $createdSocietes[1]->id,
                'nom_gare' => 'Gare Centrale Bouaké',
                'ville' => 'Bouaké',
                'adresse' => 'Centre-ville, Bouaké',
                'est_actif' => true
            ]
        ];

        $createdGares = [];
        foreach ($gares as $gareData) {
            $gare = Gare::create($gareData);
            $createdGares[] = $gare;
        }

        // Create Locations
        $lieux = [
            [
                'ville' => 'Abidjan',
                'commune' => 'Plateau',
                'type' => 'depart',
                'est_actif' => true
            ],
            [
                'ville' => 'Bouaké',
                'commune' => 'Centre-ville',
                'type' => 'arrive',
                'est_actif' => true
            ],
            [
                'ville' => 'Yamoussoukro',
                'commune' => 'Centre',
                'type' => 'les_deux',
                'est_actif' => true
            ]
        ];

        $createdLieux = [];
        foreach ($lieux as $lieuData) {
            $lieu = Lieu::create($lieuData);
            $createdLieux[] = $lieu;
        }

        // Create National Destinations
        $destinationsNationales = [
            [
                'societe_id' => $createdSocietes[0]->id,
                'gare_depart' => $createdGares[0]->id,
                'depart' => $createdLieux[0]->id,
                'arrive' => $createdLieux[1]->id,
                'tarif_unitaire' => 5000,
                'est_actif' => true
            ],
            [
                'societe_id' => $createdSocietes[1]->id,
                'gare_depart' => $createdGares[1]->id,
                'depart' => $createdLieux[1]->id,
                'arrive' => $createdLieux[2]->id,
                'tarif_unitaire' => 4500,
                'est_actif' => true
            ]
        ];

        foreach ($destinationsNationales as $destinationData) {
            DestinationNational::create($destinationData);
        }

        // Create Regional Destinations
        $destinationsSousRegion = [
            [
                'societe_id' => $createdSocietes[2]->id,
                'gare_depart' => $createdGares[0]->id,
                'pays_destination' => 'Ghana',
                'ville_destination' => 'Accra',
                'tarif_unitaire' => 25000,
                'est_actif' => true
            ]
        ];

        foreach ($destinationsSousRegion as $destinationData) {
            DestinationSousRegion::create($destinationData);
        }
    }
}