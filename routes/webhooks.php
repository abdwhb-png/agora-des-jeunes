<?php

use Illuminate\Http\Request;
use App\Enums\AccountActivityEnum;
use Illuminate\Support\Facades\Route;
use App\Services\AccountActivityLogger;

Route::post('/new-login', function (Request $request) {
    $request->validate([
        'user' => 'required|array',
        'user.id' => 'required|integer|exists:users,id',
        'user.email' => 'required|email',
    ]);
    AccountActivityLogger::log(AccountActivityEnum::LOGED_IN, $request->user['id'], ['email' => $request->user['email']]);
    return response()->json(['success' => true], 204);
});
