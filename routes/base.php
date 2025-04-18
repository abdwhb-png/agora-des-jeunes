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

require __DIR__ . '/auth.php';

// Routes pour les filtres
Route::resource('filter', FilterController::class)->only([
    'index',
    'store',
]);
Route::patch('/filter', [FilterController::class, 'reset'])->name('filter.reset');

Route::get('/' . ConfigEnum::GET_IMAGE_URL_PATH->value . '/{path}', function ($path) {
    $imagePath = public_path("images/$path");

    if (file_exists($imagePath)) {
        return response()->file($imagePath);
    }

    abort(404);
})->where('path', '.*');

Route::middleware('auth')->prefix(config('fortify.prefix'))->group(function () {
    Route::inertia('/account', 'Account/Index')->name('account');
    Route::get('/settings', [UserController::class, 'settings'])->name('settings');
    // Routes pour l'utilisateur
    Route::resource('user', UserController::class)->only([
        'show',
        'update',
    ]);
    Route::prefix('user')->as('user.')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/me', 'me')->name('me');
            Route::get('/sessions', 'sessions')->name('sessions');

            Route::put('/info/{user}', 'updateInfo')->name('info.update');
            Route::put('/account/{user}', 'updateAccount')->name('account.update');

            Route::get('/permissions', 'permissions')->name('permissions');
            Route::patch('/permissions/{user}', 'updatePermissions')->name('permissions.update');
            Route::get('/roles', 'roles')->name('roles');
            Route::patch('/roles/{user}', 'updateRoles')->name('roles.update');
        });

        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    });

    Route::controller(NotificationController::class)->group(function () {
        Route::post('/invite', 'invite')->name('user.invite');
    });

    Route::controller(NotificationController::class)->group(function () {
        Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.delete');
        Route::post('/notifications/archive', [NotificationController::class, 'archiveAll'])->name('notifications.archiveAll');
        Route::post('/notifications/read', [NotificationController::class, 'readAll'])->name('notifications.readAll');
    });

    // Routes pour la faq
    Route::resource('faq', FaqController::class)->only([
        'index',
        'show',
    ]);

    // Routes pour les sessions d'agora
    Route::resource('agora-session', AgoraSessionController::class)->only([
        'index',
        'show',
    ]);

    // Routes pour les sondages
    Route::resource('poll', PollController::class)->only([
        'index',
        'show',
    ]);

    // Routes pour les offres d'emploi
    Route::resource('job', JobOfferController::class)->only([
        'store',
        'update',
        'destroy',
    ])->middleware(['can:' . PermissionsEnum::MANAGE_JOB_OFFERS->value]);

    // Routes pour les formations
    Route::resource('training', TrainingController::class)->only([
        'store',
        'update',
        'destroy',
    ])->middleware(['can:' . PermissionsEnum::MANAGE_TRAININGS->value]);
});
