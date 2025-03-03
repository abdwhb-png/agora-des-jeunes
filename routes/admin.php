<?php

use Inertia\Inertia;
use App\Enums\PermissionsEnum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AgoraSessionController;

require __DIR__ . '/base.php';
$prefix = config('fortify.prefix');

Route::redirect('/', '/' . $prefix . '/dashboard');

Route::prefix($prefix)->middleware(['auth', 'verified'])->group(function () {
    Route::controller(GestionController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/users', 'users')->name('users');
        Route::middleware(['can:' . PermissionsEnum::MANAGE_CONFIGURATION->value])->group(function () {
            Route::get('/configuration', 'configuration')->name('configuration');
            Route::put('/site-settings/{setting}', 'updateSetting')->name('site-settings.update');
            Route::put('/social-link/{item}', 'updateSocialLink')->name('social-link.update');
            Route::post('/logout-everyone', 'logoutEveryone')->name('logout-everyone');
            Route::post('/reset-all-sessions', 'resetAllSessions')->name('reset-all-sessions');
        });
    });

    Route::resource('agora-session', AgoraSessionController::class)->only([
        'update',
        'store',
    ])->middleware(['can:' . PermissionsEnum::MANAGE_AGORA_SESSIONS->value]);

    Route::middleware(['can:' . PermissionsEnum::MANAGE_POLLS->value])->group(function () {
        Route::resource('poll', PollController::class)->only([
            'update',
            'store',
        ]);
        Route::get('polls-stats', [PollController::class, 'stats'])->name('polls.stats');
    });

    Route::resource('faq', FaqController::class)->only([
        'store',
        'update',
        'destroy',
    ]);

    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);
});
