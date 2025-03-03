<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invitation extends Model
{
    // use LogsActivity;

    protected $fillable = ['email', 'token', 'link', 'is_used', 'created_by', 'expires_at', 'name'];

    protected $appends = ['link'];

    protected $with = ['createdBy'];

    protected static $recordEvents = ['created', 'updated'];

    public function link(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ?? route('register', ['token' => $this->token]),
        );
    }

    public function hasExpired()
    {
        return $this->expires_at < now();
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => "This invitation has been {$eventName}")
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
