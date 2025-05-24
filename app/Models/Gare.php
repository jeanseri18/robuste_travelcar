<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gare extends Model
{
    use HasFactory;

    protected $fillable = [
        'societe_id',
        'nom_gare',
        'adresse',
        'ville',
        'commune',
        'telephone',
        'responsable',
        'est_actif',
    ];

    protected $casts = [
        'est_actif' => 'boolean',
    ];

    /**
     * Get the societe that owns the gare
     */
    public function societe()
    {
        return $this->belongsTo(Societe::class);
    }

    /**
     * Get the national destinations for the gare
     */
    public function destinationsNational()
    {
        return $this->hasMany(DestinationNational::class, 'gare_depart');
    }

    /**
     * Get the regional destinations for the gare
     */
    public function destinationsSousRegion()
    {
        return $this->hasMany(DestinationSousRegion::class, 'gare_depart');
    }

    /**
     * Get the reservations for the gare
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'gare_depart');
    }

    /**
     * Get the full name of the gare with societe
     */
    public function getNomCompletAttribute()
    {
        return "{$this->nom_gare} ({$this->societe->nom_commercial})";
    }

    /**
     * Get the location information
     */
    public function getLocationAttribute()
    {
        return "{$this->ville} - {$this->commune}";
    }
}