<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousTraitant extends Model
{
    use HasFactory;

    protected $table = 'sous_traitants';

    protected $fillable = [
        'user_id',
        'type',
        'nom_commercial',
        'forme_juridique',
        'capital',
        'rccm',
        'compte_contribuable',
        'adresse_geographique',
        'adresse_postale',
        'telephone_fixe',
        'telephone_mobile',
        'taux_commission',
        'commune_activite',
        'montant_cautionnement',
        'est_actif'
    ];

    protected $casts = [
        'capital' => 'decimal:2',
        'taux_commission' => 'decimal:2',
        'montant_cautionnement' => 'decimal:2',
        'est_actif' => 'boolean',
    ];

    /**
     * Get the user that owns the sous-traitant.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the lines for the sous-traitant.
     */
    public function lignes()
    {
        return $this->hasMany(LigneSousTraitant::class);
    }

    /**
     * Get the type label
     */
    public function getTypeLabelAttribute()
    {
        return $this->type === 'personne_physique' ? 'Personne Physique' : 'Personne Morale';
    }

    /**
     * Get formatted caution amount
     */
    public function getCautionnementFormatteAttribute()
    {
        return number_format($this->montant_cautionnement, 0, ',', ' ') . ' CFA';
    }

    /**
     * Get formatted commission rate
     */
    public function getCommissionFormatteAttribute()
    {
        return $this->taux_commission . '%';
    }
}