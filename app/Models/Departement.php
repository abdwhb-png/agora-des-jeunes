<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $table = 'departements';

    protected $fillable = [
        'name',
        'code',
        'residents',
    ];

    public function communes()
    {
        return $this->hasMany(Commune::class);
    }
}