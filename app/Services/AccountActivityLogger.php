<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\AccountActivity;
use App\Enums\AccountActivityEnum;

class AccountActivityLogger
{
    public static function log(AccountActivityEnum $event, $user, array $metadata = [])
    {
        $request = request();

        AccountActivity::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'event' => $event->value,
            'description' => $event->description(),
            'metadata' => [
                ...$metadata,
                'url' => $request->url(),
            ],
        ]);

        activity()
            ->withProperties(['ip_address' => $request->ip()])
            ->event($event->name)
            ->log($event->value);

        try {
            if ($event->severity()->weight() >= 50) {
            }
        } catch (\Exception) {
        }
    }
}
