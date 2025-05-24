<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinationNational extends Model
{
    use HasFactory;

    protected $table = 'destinations_national';

    protected $fillable = [
        'societe_id',
        'gare_depart',
        'depart',
        'arrive',
        'tarif_unitaire',
        'premier_depart',
        'dernier_depart',
        'capacite_bus',
        'frequence_departs',
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
     * Get the departure location
     */
    public function lieuDepart()
    {
        return $this->belongsTo(Lieu::class, 'depart');
    }

    /**
     * Get the arrival location
     */
    public function lieuArrive()
    {
        return $this->belongsTo(Lieu::class, 'arrive');
    }

    /**
     * Get reservations for this destination
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'destination_id')
                    ->where('type_destination', 'national');
    }

    /**
     * Get the route description
     */
    public function getRouteDescriptionAttribute()
    {
        $depart = $this->lieuDepart ? $this->lieuDepart->ville : 'N/A';
        $arrive = $this->lieuArrive ? $this->lieuArrive->ville : 'N/A';
        return "{$depart} → {$arrive}";
    }

    /**
     * Get formatted price
     */
    public function getPrixFormatteAttribute()
    {
        return number_format($this->tarif_unitaire, 0, ',', ' ') . ' CFA';
    }
}