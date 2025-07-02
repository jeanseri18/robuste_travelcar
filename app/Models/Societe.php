<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Societe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_commercial',
        'type',
        'forme_juridique',
        'siege_social',
        'date_creation',
        'capital',
        'rccm',
        'compte_contribuable',
        'adresse',
        'email',
        'telephone',
        'whatsapp',
        'responsable_marketing',
        'logo',
        'regime_imposition',
        'centre_impots',
        'compte_bancaire',
    ];

    protected $casts = [
        'date_creation' => 'date',
        'capital' => 'decimal:2',
    ];

    /**
     * Get the gares for the societe
     */
    public function gares()
    {
        return $this->hasMany(Gare::class);
    }

    /**
     * Get the national destinations for the societe
     */
    public function destinationsNational()
    {
        return $this->hasMany(DestinationNational::class);
    }

    /**
     * Get the regional destinations for the societe
     */
    public function destinationsSousRegion()
    {
        return $this->hasMany(DestinationSousRegion::class);
    }

    /**
     * Get the reservations for the societe
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get the sous-traitant lines for the societe
     */
    public function lignesSousTraitants()
    {
        return $this->hasMany(LigneSousTraitant::class);
    }

    /**
     * Get the logo URL attribute
     */
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return asset('images/default-logo.png');
    }

    /**
     * Scope pour filtrer les sociétés nationales
     */
    public function scopeNational($query)
    {
        return $query->where('type', 'national');
    }

    /**
     * Scope pour filtrer les sociétés sous-régionales
     */
    public function scopeSousRegional($query)
    {
        return $query->where('type', 'sousregional');
    }
}