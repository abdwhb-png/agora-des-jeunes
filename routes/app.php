<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\ProjectController;

$prefix = config('fortify.prefix');
require_once __DIR__ . '/base.php';
// Call the function to register shared routes
registerSharedRoutes(Route::getFacadeRoot());

Route::prefix($prefix)->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'onboarding',
])->group(function () {
    Route::controller(AppController::class)->group(function () {
        Route::get('/onboarding', 'onboarding')->name('onboarding');
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/profil', 'profil')->name('profil');
        Route::get('/projets', 'projets')->name('projets');
        Route::get('/emploi', 'emploi')->name('emploi');
        Route::get('/formation', 'formation')->name('formation');
        Route::get('/entreprendre', 'entreprendre')->name('entreprendre');
    });

    Route::resource('cv', CvController::class)->only([
        'store',
        'delete',
    ]);

    Route::resource('projet', ProjectController::class)->only([
        'store',
        'update',
        'delete',
    ]);
});
