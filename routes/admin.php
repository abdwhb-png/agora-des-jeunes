<?php

use Inertia\Inertia;
use App\Enums\PermissionsEnum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\PermissionController;

$prefix = config('fortify.prefix');
require_once __DIR__ . '/base.php';
// Call the function to register shared routes
registerSharedRoutes(Route::getFacadeRoot());

Route::redirect('/', '/' . $prefix . '/dashboard');

Route::prefix($prefix)->middleware(['auth', 'verified'])->group(function () {
    Route::controller(GestionController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/users', 'users')->name('users');
        Route::get('/stats', 'stats')->name('stats');
        Route::middleware(['can:' . PermissionsEnum::MANAGE_CONFIGURATION->value])->group(function () {
            Route::get('/configuration', 'configuration')->name('configuration');
            Route::put('/site-settings/{setting}', 'updateSetting')->name('site-settings.update');
            Route::put('/social-link/{item}', 'updateSocialLink')->name('social-link.update');
            Route::post('/logout-everyone', 'logoutEveryone')->name('logout-everyone');
            Route::post('/reset-all-sessions', 'resetAllSessions')->name('reset-all-sessions');
        });
    });

    Route::get('roles', [RoleController::class, 'index'])->name('roles');
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions');
    Route::resource('role', RoleController::class)->only(['store', 'update', 'destroy']);
    Route::resource('permission', PermissionController::class)->only(['store', 'update', 'destroy']);
});
