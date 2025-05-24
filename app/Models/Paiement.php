<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'user_id',
        'montant',
        'methode',
        'numero_transaction',
        'reference_transaction',
        'statut',
        'date_paiement',
        'commentaire'
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_paiement' => 'datetime',
    ];

    /**
     * Get the reservation related to the payment
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    /**
     * Get the user who made the payment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted amount
     */
    public function getMontantFormatteAttribute()
    {
        return number_format($this->montant, 0, ',', ' ') . ' CFA';
    }

    /**
     * Get payment method label
     */
    public function getMethodeLabelAttribute()
    {
        switch ($this->methode) {
            case 'orange_money':
                return 'Orange Money';
            case 'mtn_money':
                return 'MTN Money';
            case 'moov_money':
                return 'Moov Money';
            case 'wave':
                return 'Wave';
            case 'cheque':
                return 'Chèque';
            case 'virement':
                return 'Virement Bancaire';
            default:
                return ucfirst($this->methode);
        }
    }

    /**
     * Get status label with color
     */
    public function getStatutLabelAttribute()
    {
        switch ($this->statut) {
            case 'en_attente':
                return '<span class="badge bg-warning">En attente</span>';
            case 'complete':
                return '<span class="badge bg-success">Complété</span>';
            case 'echoue':
                return '<span class="badge bg-danger">Échoué</span>';
            case 'remboursement':
                return '<span class="badge bg-info">Remboursement</span>';
            default:
                return '<span class="badge bg-secondary">' . ucfirst($this->statut) . '</span>';
        }
    }

    /**
     * Scope a query to only include completed payments.
     */
    public function scopeCompletes($query)
    {
        return $query->where('statut', 'complete');
    }

    /**
     * Scope a query to only include pending payments.
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }
}