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
    Route::get('/a-propos', 'about')->name('about');
    Route::get('/faqs', 'faqs')->name('faqs');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('contact', 'contactPerform')->name('contact.perform');
});
Route::inertia('/blog', 'Blog')->name('blog');

Route::withoutMiddleware(CheckRouteMiddleware::class)->group(function () {
    $param = ConfigEnum::ENFORCE_DOMAIN_KEY->value . "=" . ConfigEnum::APP_PREFIX->value;
    Route::permanentRedirect('/connexion', '/login?' . $param)->name('connexion');
    Route::permanentRedirect('/inscription', '/register?' . $param)->name('inscription');
});
