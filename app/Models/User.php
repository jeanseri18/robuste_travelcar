<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'nom',
        'prenom',
        'email',
        'contact_telephone',
        'whatsapp',
        'date_naissance',
        'commune_residence',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_naissance' => 'date',
    ];

    /**
     * Get user's full name
     */
    public function getNomCompletAttribute()
    {
        return "{$this->nom} {$this->prenom}";
    }

    /**
     * Define relationship with reservations
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Define relationship with payments
     */
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    /**
     * Define relationship with sous-traitant
     */
    public function sousTraitant()
    {
        return $this->hasOne(SousTraitant::class);
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin()
    {
        return $this->type === 'Administrateur';
    }

    /**
     * Check if user is a traveler
     */
    public function isVoyageur()
    {
        return $this->type === 'Voyageur';
    }

    /**
     * Check if user is a sous-traitant
     */
    public function isSousTraitant()
    {
        return $this->type === 'Sous-Traitant';
    }
}