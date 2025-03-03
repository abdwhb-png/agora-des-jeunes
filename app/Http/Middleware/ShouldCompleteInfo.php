<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\ConfigEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            if (!is_admin_domain() && current_subdomain() == ConfigEnum::APP_PREFIX->value && !$request->user()->info->hasCompletedInfo()) {
                return redirect()->route('profile.show')->with('status', 'Veuillez remplir vos informations pour continuer.');
            }
        }

        return $next($request);
    }
}