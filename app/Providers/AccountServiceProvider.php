<?php

namespace App\Providers;

use App\Enums\AccountActivityEnum;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Event;
use App\Services\AccountActivityLogger;
use Illuminate\Support\Facades\Cache;

class AccountServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen(Failed::class, function ($event) {
            AccountActivityLogger::log(AccountActivityEnum::FAILED_LOGIN, $event->user, [
                'email' => $event->credentials['email'] ?? 'unknown',
            ]);
        });

        Event::listen(Login::class, function ($event) {
            AccountActivityLogger::log(AccountActivityEnum::LOGED_IN, $event->user, ['email' => $event->user->email]);
        });

        Event::listen(Logout::class, function ($event) {
            AccountActivityLogger::log(AccountActivityEnum::LOGED_OUT, $event->user, ['email' => $event->user->email]);
        });

        Event::listen(Registered::class, function ($event) {
            AccountActivityLogger::log(AccountActivityEnum::REGISTERED, $event->user, ['email' => $event->user->email]);
        });

        Event::listen(PasswordReset::class, function ($event) {
            AccountActivityLogger::log(AccountActivityEnum::PASSWORD_RESET, $event->user, ['email' => $event->user->email]);
        });

        Event::listen(Failed::class, function ($event) {
            $ip = request()->ip();
            $email = $event->credentials['email'] ?? 'unknown';
            $key = "failed_login_attempts:{$ip}";

            // Incrémenter le compteur d’échecs
            $attempts = Cache::increment($key);
            Cache::put($key, $attempts, now()->addMinutes(10));

            if ($attempts >= 5) {
                AccountActivityLogger::log(AccountActivityEnum::SUSPICIOUS_LOGIN_ATTEMPT, $event->user, [
                    'email' => $email,
                    'attempts' => $attempts
                ]);
            }
        });
    }
}
