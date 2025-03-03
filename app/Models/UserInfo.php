<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserInfo extends Model
{
    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'sexe',
        'date_naissance',
        'profession',
        'ville',
        'quartier',
        'arrondissement',
        'maison',
    ];

    protected $appends = ['full_name', 'full_address'];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->nom ? $this->nom . ' ' . $this->prenom : $this->prenom,
        );
    }

    protected function fullAddress(): Attribute
    {
        $start = $this->pays . ', ' . $this->departement;
        $middle = $this->ville . ', ' . $this->quartier;
        $end = $this->arrondissement . ', ' . $this->maison;
        return Attribute::make(
            get: fn() => "{$start}, {$middle}, {$end}",
        );
    }

    public function hasCompletedInfo(): bool
    {
        return $this->nom && $this->prenom && $this->sexe && $this->date_naissance &&  $this->quartier;
    }

    public function avatar(): string
    {
        switch ($this->sexe) {
            case 'masculin':
                return asset('images/avatars/male.png');
            case 'feminin':
                return asset('images/avatars/female.jpg');
            default:
                return asset('images/avatars/default.png');
        }
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
