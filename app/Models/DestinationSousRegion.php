<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinationSousRegion extends Model
{
    use HasFactory;

    protected $table = 'destinations_sousregion';

    protected $fillable = [
        'societe_id',
        'gare_depart',
        'pays_depart',
        'ville_depart',
        'pays_destination',
        'ville_destination',
        'adresse_destination',
        'tarif_unitaire',
        'premier_depart',
        'dernier_depart',
        'capacite_bus',
        'duree_trajet',
        'est_actif'
    ];

    protected $casts = [
        'tarif_unitaire' => 'decimal:2',
        'premier_depart' => 'datetime:H:i',
        'dernier_depart' => 'datetime:H:i',
        'est_actif' => 'boolean',
    ];

    /**
     * Get the societe that owns the destination
     */
    public function societe()
    {
        return $this->belongsTo(Societe::class);
    }

    /**
     * Get the gare for the destination
     */
    public function gareDepart()
    {
        return $this->belongsTo(Gare::class, 'gare_depart');
    }

    /**
     * Get reservations for this destination
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'destination_id')
                    ->where('type_destination', 'sousregion');
    }

    /**
     * Get the route description
     */
    public function getRouteDescriptionAttribute()
    {
        $depart = $this->gareDepart ? $this->gareDepart->ville : 'N/A';
        return "{$depart} → {$this->pays_destination} ({$this->ville_destination})";
    }

    /**
     * Get formatted price
     */
    public function getPrixFormatteAttribute()
    {
        return number_format($this->tarif_unitaire, 0, ',', ' ') . ' CFA';
    }

    /**
     * Get formatted travel time
     */
    public function getDureeFormatteAttribute()
    {
        if (!$this->duree_trajet) {
            return 'N/A';
        }
        
        if ($this->duree_trajet < 24) {
            return $this->duree_trajet . ' heures';
        }
        
        $jours = floor($this->duree_trajet / 24);
        $heures = $this->duree_trajet % 24;
        
        if ($heures == 0) {
            return $jours . ' jour' . ($jours > 1 ? 's' : '');
        }
        
        return $jours . ' jour' . ($jours > 1 ? 's' : '') . ' et ' . $heures . ' heure' . ($heures > 1 ? 's' : '');
    }
}