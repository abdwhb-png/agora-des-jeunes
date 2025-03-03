<?php

namespace App\Models;

use App\Models\UniversityFilial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TopUniversity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'ranking',
        'description',
        'website',
    ];

    public function filials(): HasMany
    {
        return $this->hasMany(UniversityFilial::class);
    }
}