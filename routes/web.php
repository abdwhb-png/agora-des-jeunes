<?php

use App\Enums\ConfigEnum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\CheckRouteMiddleware;

// Route::fallback(function () {
//     return redirect()->route('home');
// });

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/faqs', 'faqs')->name('faqs');
    Route::post('contact', 'contact')->name('contact.perform');
});
Route::inertia('/contact', 'Contact')->name('contact');
Route::inertia('/a-propos', 'About')->name('about');
Route::inertia('/blog', 'Blog')->name('blog');

Route::withoutMiddleware(CheckRouteMiddleware::class)->group(function () {
    $param = ConfigEnum::ENFORCE_DOMAIN_KEY->value . "=" . ConfigEnum::APP_PREFIX->value;
    // $redirectParams = [ConfigEnum::ENFORCE_DOMAIN_KEY->value => ConfigEnum::APP_PREFIX->value];
    Route::permanentRedirect('/connexion', '/login?' . $param)->name('connexion');
    Route::permanentRedirect('/inscription', '/register?' . $param)->name('inscription');
});
