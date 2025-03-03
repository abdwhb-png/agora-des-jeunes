<?php

use App\Enums\ConfigEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            $adminSubdomain = ConfigEnum::ADMIN_PREFIX->value . ".";
            $prefix = config('fortify.prefix');

            Route::middleware('web')
                ->domain($adminSubdomain . config('app.url'))
                ->as($adminSubdomain)
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->prefix($prefix)
                ->group(base_path('routes/app.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('webhooks')
                ->name('webhooks.')
                ->group(base_path('routes/webhooks.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(
            prepend: [
                \App\Http\Middleware\CheckRouteMiddleware::class,
            ],
            append: [
                \App\Http\Middleware\HandleInertiaRequests::class,
                \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
                \App\Http\Middleware\SetInertiaRootView::class,
                \App\Http\Middleware\ShouldCompleteInfo::class,
            ]
        );

        $middleware->statefulApi();

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (\Symfony\Component\HttpFoundation\Response $response, Throwable $exception, Request $request) {
            $for500 = ! app()->environment(['local', 'testing']) && $response->getStatusCode() === 500;

            if (false && !current_subdomain()) {
                $page = '404';
            } else if (in_array($response->getStatusCode(), [403, 404, 419]) || $for500) {
                $page = 'Error/' . $response->getStatusCode();
            }

            if (isset($page)) {
                return \Inertia\Inertia::render(
                    $page,
                    [
                        'errorStatus' => $response->getStatusCode(),
                        'pageType' => 'error',
                    ]
                )
                    ->toResponse($request)
                    ->setStatusCode($response->getStatusCode());
            }

            return $response;
        });

        $exceptions->render(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Vous n\'avez pas les droits suffisants pour accéder à cette ressource.',
                    'status'  => 403,
                ], 403);
            } else {
                return \Inertia\Inertia::render('Error/403', ['status' => 'Vous n\'avez pas les droits suffisants pour accéder à cette page.'])
                    ->toResponse($request)
                    ->setStatusCode(403);
            }
        });
    })->create();