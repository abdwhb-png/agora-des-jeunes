<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'is_public', 'start_at', 'end_at', 'show_options', 'published'];

    protected $appends = ['is_expired', 'with_options'];

    protected $with = ['options'];

    protected $casts = [
        'is_public' => 'boolean',
        'published' => 'boolean',
        'show_options' => 'boolean',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    protected function isExpired(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->end_at ? $this->end_at < now() : false,
        );
    }

    protected function withOptions(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->options()->count() > 0,
        );
    }

    public function options()
    {
        return $this->hasMany(PollOption::class);
    }

    public function votes()
    {
        return $this->hasMany(PollVote::class);
    }

    public function scopeNotExpired($query)
    {
        return $query->where('start_at', '<=', now())
            ->where('end_at', '>=', now());
    }
}
