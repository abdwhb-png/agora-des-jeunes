<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\CvController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/user', 'show')->name('user');
        Route::get('/users', 'index')->name('users');
        Route::get('/managers', 'managers')->name('managers');
    });

    Route::controller(ApiController::class)->group(function () {
        Route::post('/upload-image', 'uploadImage');
        Route::get('departements', 'getDepartements');
        Route::get('features', 'getFeatures');

        Route::post('ai-usage', 'aiUsage');
    });
});
