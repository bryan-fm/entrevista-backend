<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KindController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    //User Routes
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users/create', [UserController::class, 'store']);
    Route::post('/users/update/{userId}', [UserController::class, 'update']);
    Route::get('/users/all', [UserController::class, 'allUsers']);
    Route::get('/users/{userId}', [UserController::class, 'find']);

    //Kind Routes
    Route::get('/kinds', [KindController::class, 'index']);
    Route::post('/kinds/create', [KindController::class, 'store']);
    Route::post('/kinds/update/{kindId}', [KindController::class, 'update']);
    Route::get('/kinds/all', [KindController::class, 'allKinds']);
    Route::get('/kinds/{kindId}', [KindController::class, 'find']);
    Route::get('/kinds/delete/{kindId}', [KindController::class, 'delete']);
});