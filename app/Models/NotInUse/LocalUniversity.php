<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LocalUniversity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'ranking',
        'description',
        'website',
    ];

    public function filials(): HasMany
    {
        return $this->hasMany(UniversityFilial::class);
    }
}