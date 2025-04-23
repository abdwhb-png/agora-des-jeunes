<?php

namespace App\Models;

use App\Enums\GenderEnum;
use App\Enums\AccountActivityEnum;
use App\Services\AccountActivityLogger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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
        'departement',
        'quartier',
        'arrondissement',
        'maison',
    ];

    protected $appends = ['full_name', 'full_address'];

    static function booted()
    {
        static::updated(function ($info) {
            AccountActivityLogger::log(AccountActivityEnum::PROFILE_UPDATED, $info->user);
        });
    }

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch(Builder $query, $search)
    {
        $query->where('nom', 'like', '%' . $search . '%')
            ->orWhere('prenom', 'like', '%' . $search . '%')
            ->orWhere('sexe', 'like', '%' . $search . '%')
            ->orWhere('date_naissance', 'like', '%' . $search . '%')
            ->orWhere('profession', 'like', '%' . $search . '%')
            ->orWhere('pays', 'like', '%' . $search . '%')
            ->orWhere('departement', 'like', '%' . $search . '%')
            ->orWhere('ville', 'like', '%' . $search . '%')
            ->orWhere('quartier', 'like', '%' . $search . '%')
            ->orWhere('arrondissement', 'like', '%' . $search . '%')
            ->orWhere('maison', 'like', '%' . $search . '%')
            // Search for full name by combining first and last name
            ->orWhereRaw("CONCAT(nom, ' ', prenom) LIKE ?", ['%' . $search . '%'])
            ->orWhereRaw("CONCAT(prenom, ' ', nom) LIKE ?", ['%' . $search . '%']);
    }

    public function hasCompletedPersonalInfo(): bool
    {
        return $this->nom && $this->prenom && $this->sexe && $this->date_naissance;
    }

    public function hasCompletedAddress(): bool
    {
        return $this->quartier !== null && $this->ville !== null;
    }

    public function avatar(): string
    {
        switch ($this->sexe) {
            case GenderEnum::MALE->value:
                return asset('images/avatars/male-3d.png');
            case GenderEnum::FEMALE->value:
                return asset('images/avatars/female-3d.png');
            default:
                return asset('images/avatars/default.png');
        }
    }
}
