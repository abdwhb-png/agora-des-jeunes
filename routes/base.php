<?php

use App\Enums\ConfigEnum;
use App\Enums\PermissionsEnum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\Base\BaseController;
use App\Http\Controllers\AgoraSessionController;
use App\Http\Controllers\NotificationController;

/**
 * Shared route registration function to avoid duplicate route definitions.
 * This function should be called from both app.php and admin.php 
 * instead of requiring this file directly.
 */
function registerSharedRoutes($router)
{
    // Common routes that don't need authentication
    $router->resource('filter', FilterController::class)->only([
        'index',
        'store',
    ]);
    $router->patch('/filter', [FilterController::class, 'reset'])->name('filter.reset');

    $router->get('/' . ConfigEnum::GET_IMAGE_URL_PATH->value . '/{path}', function ($path) {
        $imagePath = public_path("images/$path");

        if (file_exists($imagePath)) {
            return response()->file($imagePath);
        }

        abort(404);
    })->where('path', '.*');

    // Authenticated routes
    $router->middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
        'onboarding',
    ])->prefix(config('fortify.prefix'))->group(function () use ($router) {
        $router->controller(UsersController::class)->group(function () use ($router) {
            $router->post('/joining-invite', 'joiningInvite')->name('joining.invite');
            $router->patch('/permissions/{user}', 'updatePermissions')->name('permissions.update');
            $router->patch('/roles/{user}', 'updateRoles')->name('roles.update');
        });

        $router->inertia('/account', 'Account/Index')->name('account');
        $router->get('/settings', [UserController::class, 'settings'])->name('settings');

        // Routes pour l'utilisateur
        $router->prefix('user')->as('user.')->group(function () use ($router) {
            $router->controller(UserController::class)->group(function () use ($router) {
                $router->get('/index', 'index')->name('index');
                $router->get('/me', 'me')->name('me');
                $router->get('/show/{id}', 'show')->name('show');
                $router->get('/sessions', 'sessions')->name('sessions');

                $router->put('/info/{user}', 'updateInfo')->name('info.update');
                $router->put('/account/{user}', 'updateAccount')->name('account.update');
                $router->match(['post', 'put'], "/profile-photo", "updateProfilePhoto")->name("profile-photo.update");

                $router->get('/permissions', 'permissions')->name('permissions');
                $router->get('/roles', 'roles')->name('roles');
            });

            $router->get('/notifications', [NotificationController::class, 'index'])->name('notifications');
        });

        // Routes pour les notifications
        $router->controller(NotificationController::class)->group(function () use ($router) {
            $router->post('/notifications/{notification}/read', 'markAsRead')->name('notifications.read');
            $router->delete('/notifications/{notification}', 'destroy')->name('notifications.delete');
            $router->post('/notifications/archive', 'archiveAll')->name('notifications.archiveAll');
            $router->post('/notifications/read', 'readAll')->name('notifications.readAll');
        });

        // Routes pour la faq
        $router->resource('faq', FaqController::class);

        // Routes pour les sessions d'agora
        $router->resource('agora-session', AgoraSessionController::class);

        // Routes pour les sondages
        $router->resource('poll', PollController::class);

        // Routes pour les offres d'emploi
        $router->resource('job-offer', JobOfferController::class);

        // Routes pour les formations
        $router->resource('training', TrainingController::class);
    });
}

// Note: Do not define routes directly in this file anymore.
// The function above should be called from app.php and admin.php
