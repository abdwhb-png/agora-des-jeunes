<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Professional extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'profession',
        'location',
        'contact_info',
        'bio',
    ];

    // Relation avec les utilisateurs
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_professional_links')
            ->withPivot('status')
            ->withTimestamps();
    }
}