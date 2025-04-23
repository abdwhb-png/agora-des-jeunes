<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\ConfigEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class Onboarding
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentRoute = Route::currentRouteName();
        $onBoardingRoute = 'onboarding';
        $shouldRedirect = !is_admin_domain() && is_on_app() && !in_array($currentRoute, [
            $onBoardingRoute,
            'dashboard',
        ]);

        if (
            $shouldRedirect &&
            (!$request->user()->info?->hasCompletedPersonalInfo() || !$request->user()->info?->hasCompletedAddress())
        ) {
            return redirect()->route($onBoardingRoute)
                ->with('status', 'Merci de compléter les informations suivantes pour continuer.');
        }
        return $next($request);
    }
}
