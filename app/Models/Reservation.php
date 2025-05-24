<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_destination',
        'destination_id',
        'societe_id',
        'gare_depart',
        'lieu_embarquement',
        'date_depart',
        'heure_depart',
        'tarif_unitaire',
        'nombre_tickets',
        'total',
        'assurance_voyageur',
        'assurance_bagages',
        'cout_assurance',
        'statut',
        'statut_paiement',
        'code_reservation',
        'nom_voyageur',
        'contact_voyageur',
        'commentaire'
    ];

    protected $casts = [
        'date_depart' => 'date',
        'heure_depart' => 'datetime:H:i',
        'tarif_unitaire' => 'decimal:2',
        'total' => 'decimal:2',
        'cout_assurance' => 'decimal:2',
        'assurance_voyageur' => 'boolean',
        'assurance_bagages' => 'boolean',
    ];

    /**
     * Boot method to set code reservation on creation
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($reservation) {
            if (!$reservation->code_reservation) {
                $reservation->code_reservation = 'TRAV-' . strtoupper(uniqid());
            }
        });
    }

    /**
     * Get the user who made the reservation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the societe for the reservation
     */
    public function societe()
    {
        return $this->belongsTo(Societe::class);
    }

    /**
     * Get the gare for the reservation
     */
    public function gare()
    {
        return $this->belongsTo(Gare::class, 'gare_depart');
    }

    /**
     * Get the destination for the reservation (polymorphic relation)
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
     * Get the payment for the reservation
     */
    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }

    /**
     * Get formatted total
     */
    public function getTotalFormatteAttribute()
    {
        return number_format($this->total, 0, ',', ' ') . ' CFA';
    }

    /**
     * Get status label with color
     */
    public function getStatutLabelAttribute()
    {
        switch ($this->statut) {
            case 'en_attente':
                return '<span class="badge bg-warning">En attente</span>';
            case 'confirmee':
                return '<span class="badge bg-success">Confirmée</span>';
            case 'annulee':
                return '<span class="badge bg-danger">Annulée</span>';
            default:
                return '<span class="badge bg-secondary">' . ucfirst($this->statut) . '</span>';
        }
    }

    /**
     * Scope a query to only include confirmed reservations.
     */
    public function scopeConfirmees($query)
    {
        return $query->where('statut', 'confirmee');
    }

    /**
     * Scope a query to only include pending reservations.
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    /**
     * Scope a query to only include cancelled reservations.
     */
    public function scopeAnnulees($query)
    {
        return $query->where('statut', 'annulee');
    }
}