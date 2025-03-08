<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\ConfigEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class ShouldCompleteInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $routeName = 'profile.show';
            $noRedirect = Route::currentRouteName() === $routeName;
            if (!is_admin_domain() && is_on_app() && !$noRedirect && (!$request->user()->info->hasCompletedPersonalInfo() || !$request->user()->info->hasCompletedAddress())) {
                return redirect()->route($routeName)
                    ->with('status', 'Merci de compléter les informations suivantes pour continuer.');
            }
        }

        return $next($request);
    }
}
