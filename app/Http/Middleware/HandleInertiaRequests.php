<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Helpers\ConfigHelper;
use App\Http\Resources\UserResource;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        $this->rootView = 'home';
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'app' => Arr::only(config('app'), ['cv_builder_url', 'env', 'frontend_url', 'name', 'url']),
            'config' => ConfigHelper::getConfig(),
            'routePrefix' => route_prefix(),
            'socialAuth' => ['facebook', 'google'],

            'dev' => [
                'name' => 'Your DevLab',
                'site_url' => '#',
            ],

            'auth' => [
                'user' => fn() => $request->user()
                    ? new UserResource($request->user())
                    : null,
                'unreadNotifications' => fn() => $request->user() ? $request->user()->unreadNotifications : null,
                'auth_token' => session()->get('auth_token'),
            ],

            'filters' => fn() => $request->session()->get('filters', []),

            'flash' => [
                'status' => fn() => $request->session()->get('status'),
                'success' => fn() => $request->session()->get('success'),
                'fail' => fn() => $request->session()->get('fail'),
            ],
        ]);
    }
}
