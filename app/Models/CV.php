<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CV extends Model
{
    use HasFactory;

    protected $table = 'cvs';

    protected $with = ['user'];

    protected $fillable = [
        'user_id',
        'user_email',
        'resume_id',
        'title',
        'sections',
        'theme_color',
        'file_path',
    ];

    protected function casts(): array
    {
        return [
            'sections' => 'array',
        ];
    }

    public static function booted()
    {
        static::created(function ($cv) {
            $cv->info()->create([
                'first_name' => $cv->user->info->prenom ?? null,
                'last_name' => $cv->user->info->nom ?? null,
                'address' => $cv->user->info->full_address ?? null,
                'phone' => $cv->user->phone ?? null,
                'email' => $cv->user->email ?? $cv->email,
            ]);
        });
    }

    // Relation avec l'utilisateur
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function info(): HasOne
    {
        return $this->hasOne(CvInfo::class, 'cv_id');
    }
}