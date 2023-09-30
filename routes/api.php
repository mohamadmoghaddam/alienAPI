<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/chats', [ChatController::class, 'index']);

Route::get('/chats/{chat}/messages', [MessageController::class, 'show'])->missing(function(){
    return response()->json('Chat not found', 404);
});

Route::post('/chats/{chat}/messages', [MessageController::class, 'store'])->missing(function(){
    return response()->json('Chat not found', 404);
})->middleware('auth:sanctum');

Route::delete('/chats/{chat}/messages/{message}', [MessageController::class, 'destroy'])->missing(function(){
    return response()->json('Chat not found', 404);
})->middleware('auth:sanctum');

