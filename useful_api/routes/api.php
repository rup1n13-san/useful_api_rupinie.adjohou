<?php

use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ShortlinkController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserModuleController;
use App\Http\Middleware\CheckModuleActive;
use App\Models\Shortlink;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/users', [UserController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/modules/{id}/activate', [UserModuleController::class, 'activate']);
    Route::post('/modules/{id}/deactivate', [UserModuleController::class, 'deactivate']);
    
    Route::get('/modules', [ModuleController::class, 'index']);
    Route::get('/user/modules', [UserModuleController::class, 'getUserModule']);
    
    // shortlinks route
    Route::middleware('isModuleActive:1')->group(function() {
        Route::post('/shorten', [ShortlinkController::class, 'createShortLink']);

        Route::get('/s/{code}', [ShortlinkController::class, 'redirectToLink']);
        Route::get('/links', [ShortlinkController::class, 'getLinks']);
        
        Route::delete('/links/{id}', [ShortlinkController::class, 'delete']);
    });
    
    // wallet route
    Route::middleware('isModuleActive:2')->group(function() {
        Route::get('/wallet', [UserController::class, 'wallet']);
        Route::get('/wallet/transactions', [TransactionController::class, 'transactions']);
        
        Route::post('/wallet/transfer', [TransactionController::class, 'transfer']);
        Route::post('/wallet/topup', [TransactionController::class, 'topup']);

    });
});