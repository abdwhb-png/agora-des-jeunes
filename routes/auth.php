<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\SocialController;


Route::get('/auth/{provider}/redirect', [SocialController::class, 'redirect'])
    ->where('provider', 'facebook|google')->name('social.redirect');

Route::get('/auth/{provider}/callback', [SocialController::class, 'callback'])
    ->where('provider', 'facebook|google')->name('social.callback');