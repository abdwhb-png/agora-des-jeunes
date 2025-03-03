<?php

namespace App\Http\Middleware;

use Closure;
use Inertia\Inertia;
use App\Enums\ConfigEnum;
use Illuminate\Http\Request;
use App\Http\Helpers\ConfigHelper;
use Illuminate\Support\Facades\Auth;

class SetInertiaRootView
{
    public function handle(Request $request, Closure $next)
    {
        $view = 'home';

        $checkOnDomain = is_admin_domain() || is_app_domain() ;
        if (str_starts_with($request->path(), config('fortify.prefix'))) {
            $view = 'app';
        }

        Inertia::setRootView($view);

        return $next($request);
    }
}