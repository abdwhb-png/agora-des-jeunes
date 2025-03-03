<?php

use App\Http\Controllers\AgoraSessionController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PollController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('user-resumes')->controller(CvController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{cv:resume_id}', 'getResume');
    Route::put('/{cv:resume_id}', 'update');
    Route::delete('/{cv:resume_id}', 'destroy');
});


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
    });

    Route::resource('polls', PollController::class)->only([
        'index',
        'show',
    ]);

    Route::resource('faqs', FaqController::class)->only([
        'index',
        'show',
    ]);

    Route::resource('agora-sessions', AgoraSessionController::class)->only([
        'index',
        'show',
    ]);
});
