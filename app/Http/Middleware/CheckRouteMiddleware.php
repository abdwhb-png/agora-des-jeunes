<?php

namespace App\Http\Middleware;

use Closure;
use Inertia\Inertia;
use App\Enums\ConfigEnum;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRouteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = ConfigEnum::ENFORCE_DOMAIN_KEY->value;
        $request->validate([
            $key => 'sometimes|in:' . ConfigEnum::ADMIN_PREFIX->value . ',' . ConfigEnum::APP_PREFIX->value
        ]);

        if ($request->has($key)) {
            $url = url_from_subdomain($request->get($key));
            return $request->headers->has('X-Inertia') ? Inertia::location($url) : redirect()->away($url);
        }

        return $next($request);
    }
}