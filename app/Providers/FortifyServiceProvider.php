<?php

namespace App\Providers;

use App\Models\User;
use Inertia\Inertia;
use App\Enums\RolesEnum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Route;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::loginView(
            function (Request $request) {
                if (config('app.env') === 'local') {
                    $default = is_admin_domain() ? User::role(RolesEnum::ROOT->value)->first() : User::onlyUsers()->first();
                }

                return Inertia::render('Auth/Login', [
                    'canResetPassword' => Route::has('password.request'),
                    'status' => session('status'),
                    'defaultEmail' => isset($default) ? $default->email : null,
                ]);
            }
        );

        Fortify::registerView(
            function (Request $request) {
                $token = $request->get('token');
                $invitation = \App\Models\Invitation::where('token', $token)->where('is_used', false)->first();

                $authStatus = null;
                if ($invitation) {
                    if ($invitation->is_used || $invitation->hasExpired()) {
                        $authStatus = [
                            'message' => "Le lien d'invitation est invalide ou a été déjà utilisé.",
                            "severity" => 'error',
                        ];
                    }
                }

                return Inertia::render('Auth/Register', [
                    'invitation' => $invitation,
                    'authStatus' => $authStatus,
                ]);
            }
        );

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
