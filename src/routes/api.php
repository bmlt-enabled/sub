<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('subscribe', [SubscriberController::class, 'subscribe']);
Route::post('send', [MessageController::class, 'send'])->name('api.messages.send');
