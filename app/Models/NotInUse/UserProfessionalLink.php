<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProfessionalLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'professional_id',
        'status',
    ];

    // Relation avec l'utilisateur
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec le professionnel
    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }
}