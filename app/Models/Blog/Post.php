<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'collection_id',
        'user_id',
        'title',
        'slug',
        'content',
        'custom_fields',
        'seo_meta',
        'published_at',
        'status',
    ];

    protected $casts = [
        'custom_fields' => 'array',
        'seo_meta' => 'array',
        'published_at' => 'datetime',
    ];

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
