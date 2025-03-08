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
        $enforceDomain = ConfigEnum::ENFORCE_DOMAIN_KEY->value;
        $redirectTo = ConfigEnum::REDIRECT_TO_KEY->value;

        $request->validate([
            $enforceDomain => 'sometimes|in:' . ConfigEnum::ADMIN_PREFIX->value . ',' . ConfigEnum::APP_PREFIX->value,
            $redirectTo => 'sometimes|in:' . config('app.cv_builder_url')
        ]);

        if ($request->has($enforceDomain)) {
            $url = url_from_subdomain($request->get($enforceDomain));
            return $request->headers->has('X-Inertia') ? Inertia::location($url) : redirect()->away($url);
        }

        return $next($request);
    }
}
