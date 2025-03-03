<?php

namespace App\Models;

use App\Enums\AccountActivityEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountActivity extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ip_address', 'user_agent', 'event', 'description', 'metadata'];

    protected $casts = [
        'metadata' => 'array',
    ];

    protected $appends = ['severity'];

    protected function severity(): Attribute
    {
        $event = array_find(AccountActivityEnum::all(), fn($case) => $case['value'] === $this->event);

        return Attribute::make(
            get: fn() => $event ? $event['severity'] : null,
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
