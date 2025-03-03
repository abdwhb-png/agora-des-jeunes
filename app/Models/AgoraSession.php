<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgoraSession extends Model
{
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    protected $appends = [
        'image_url',
    ];

    protected function defaultImage()
    {
        return asset('images/sessions_default-min.jpg');
    }

    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->image ? url('storage/' . $this->image) : $this->defaultImage(),
        );
    }

    public function applications(): HasMany
    {
        return $this->hasMany(SessionApplication::class);
    }
}
