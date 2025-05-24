<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lieu extends Model
{
    use HasFactory;

    protected $table='lieux';
    protected $fillable = [
        'ville',
        'commune',
        'region',
        'departement',
        'sous_prefecture',
        'type',
        'est_actif'
    ];

    protected $casts = [
        'est_actif' => 'boolean',
    ];

    /**
     * Get all destinations that have this lieu as departure
     */
    public function departsNational()
    {
        return $this->hasMany(DestinationNational::class, 'depart');
    }

    /**
     * Get all destinations that have this lieu as arrival
     */
    public function arrivesNational()
    {
        return $this->hasMany(DestinationNational::class, 'arrive');
    }

    /**
     * Get the full location name
     */
    public function getLocationCompleteAttribute()
    {
        $location = $this->ville;
        
        if ($this->commune) {
            $location .= " - {$this->commune}";
        }
        
        if ($this->region) {
            $location .= " ({$this->region})";
        }
        
        return $location;
    }

    /**
     * Scope a query to only include departure places.
     */
    public function scopeDepart($query)
    {
        return $query->where('type', 'depart')->orWhere('type', 'les_deux');
    }

    /**
     * Scope a query to only include arrival places.
     */
    public function scopeArrive($query)
    {
        return $query->where('type', 'arrive')->orWhere('type', 'les_deux');
    }
}