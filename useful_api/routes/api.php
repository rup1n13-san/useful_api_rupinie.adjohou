<?php

use App\Http\Controllers\ModuleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserModuleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/modules/{id}/activate', [UserModuleController::class, 'activate']);
    Route::post('/modules/{id}/deactivate', [UserModuleController::class, 'deactivate']);
    Route::get('/modules', [ModuleController::class, 'index']);
});