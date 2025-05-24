<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneSousTraitant extends Model
{
    use HasFactory;

    protected $table = 'lignes_sous_traitants';

    protected $fillable = [
        'sous_traitant_id',
        'type_destination',
        'destination_id',
        'societe_id',
        'type_ligne',
        'est_actif'
    ];

    protected $casts = [
        'est_actif' => 'boolean',
    ];

    /**
     * Get the sous-traitant that owns the line.
     */
    public function sousTraitant()
    {
        return $this->belongsTo(SousTraitant::class);
    }

    /**
     * Get the societe for the line.
     */
    public function societe()
    {
        return $this->belongsTo(Societe::class);
    }

    /**
     * Get the destination for the line (polymorphic relation)
     */
    public function destination()
    {
        if ($this->type_destination === 'national') {
            return $this->belongsTo(DestinationNational::class, 'destination_id');
        } else {
            return $this->belongsTo(DestinationSousRegion::class, 'destination_id');
        }
    }

    /**
     * Get the type label
     */
    public function getTypeLabelAttribute()
    {
        switch ($this->type_ligne) {
            case 'aller_simple':
                return 'Aller Simple';
            case 'retour_simple':
                return 'Retour Simple';
            case 'aller_retour':
                return 'Aller-Retour';
            default:
                return ucfirst($this->type_ligne);
        }
    }

    /**
     * Get destination type label
     */
    public function getTypeDestinationLabelAttribute()
    {
        return $this->type_destination === 'national' ? 'National' : 'Sous-Régional';
    }
}