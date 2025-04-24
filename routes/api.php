<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'me'])->name('user');

    Route::controller(UsersController::class)->group(function () {
        Route::get('/users', 'index')->name('users');
        Route::get('/managers', 'managers')->name('managers');
    });

    Route::controller(ApiController::class)->group(function () {
        Route::post('/upload-image', 'uploadImage');
        Route::get('departements', 'getDepartements');
        Route::get('features', 'getFeatures');
        Route::get('stats', 'getStats');

        Route::post('ai-usage', 'aiUsage');
    });

    Route::post('/ai/chat', [AiController::class, 'chat'])->name('ai.chat');
});
