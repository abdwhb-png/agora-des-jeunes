<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionApplication extends Model
{
    protected $fillable = ['agora_session_id', 'user_id', 'ip_address', 'session_id'];

    public function session(): BelongsTo
    {
        return $this->belongsTo(AgoraSession::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
