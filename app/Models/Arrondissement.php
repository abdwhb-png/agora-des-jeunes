<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arrondissement extends Model
{
    protected $table = 'arrondissements';

    protected $fillable = [
        'nom',
        'code',
        'residents',
        'ville_id',
    ];

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }
}