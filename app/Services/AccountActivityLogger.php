<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\AccountActivity;
use App\Enums\AccountActivityEnum;
use Illuminate\Support\Facades\Auth;

class AccountActivityLogger
{
    public static function log(AccountActivityEnum $event, array $metadata = [])
    {
        $request = request();

        AccountActivity::create([
            'user_id' => Auth::id(),
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