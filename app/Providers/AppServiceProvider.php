<?php

namespace App\Providers;

use App\Models\User;
use App\Enums\RolesEnum;
use Laravel\Pulse\Facades\Pulse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('Helpers/helpers.php');

        $loader = AliasLoader::getInstance();

        $loader->alias('NoCaptcha', \Anhskohbo\NoCaptcha\Facades\NoCaptcha::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\User::observe(\App\Observers\UserObserver::class);

        \Illuminate\Http\Resources\Json\JsonResource::withoutWrapping();

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Activation de compte : ' . config('app.name'))
                ->greeting('Salut et bienvenue ' . $notifiable->info->full_name)
                ->line('Tu es prié(e)de cliquer sur le bouton ci-dessous pour activer ton compte.')
                ->line('Cette étape est nécessaire pour pouvoir bénéficier pleinement de nos services !')
                ->action('Activer Mon Compte', $url);
        });

        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('google', \SocialiteProviders\Google\Provider::class);
            $event->extendSocialite('facebook', \SocialiteProviders\Facebook\Provider::class);
        });

        // Implicitly grant "ROOT" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole(RolesEnum::ROOT->value) ? true : null;
        });

        Gate::define('viewPulse', function (User $user) {
            return $user->isRoot();
        });

        Pulse::user(fn($user) => [
            'name' => $user->info->full_name,
            'extra' => $user->email,
            'avatar' => $user->profile_photo_url,
        ]);
    }
}
