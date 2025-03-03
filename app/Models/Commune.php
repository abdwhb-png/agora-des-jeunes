<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Commune extends Model
{
    protected $table = 'communes';

    protected $fillable = [
        'name',
        'code',
        'residents',
        'quartiers',
        'departement_id',
    ];

    protected function quartiers(): Attribute
    {
        return Attribute::make(
            get: fn(string | null $value) => $value ? explode(',', $value) : [],
        );
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function arrondissements()
    {
        return $this->hasMany(Arrondissement::class);
    }
}