<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\ProjectController;

require __DIR__ . '/base.php';

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::controller(AppController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/profil', 'profil')->name('profil');
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
