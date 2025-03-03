<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Laravel\Jetstream\Http\Controllers\Inertia\UserProfileController;

trait HasSessions
{
    public function getSessions(Request $request)
    {
        $controller = new UserProfileController();

        return $controller->sessions($request);
    }
}
