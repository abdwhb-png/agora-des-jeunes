<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;

require __DIR__ . '/base.php';

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::controller(AppController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/emploi', 'emploi')->name('emploi');
        Route::get('/formation', 'formation')->name('formation');
        Route::get('/entreprendre', 'entreprendre')->name('entreprendre');
    });
});