<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;

class CustomAuthAction
{
    public function __invoke(Request $request, $next)
    {
        $user = $request->user();
        $user->disableLogging();
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);
        $user->enableLogging();

        $token = $user->createToken($user->email ?? 'api_token');
        session(['api_token' => $token->plainTextToken]);

        return $next($request);
    }

    protected function isUserAllowedToLogin(Request $request)
    {
        // Implement your custom logic
        return true; // Change this as per your requirements
    }
}