<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v1',
], function () {
    Route::middleware('auth:api')->group(function () {
        Route::group([
            'prefix' => 'dashboard',
        ], function () {
            Route::get('insights', [DashboardController::class, 'getInsights']);
        });
        
        Route::group([
            'prefix' => 'users',
        ], function () {
            Route::get('/status', [UserController::class, 'status']);
        });
    
        Route::group([
            'prefix' => 'transactions',
        ], function () {
            Route::get('', [TransactionController::class, 'index']);
            Route::post('', [TransactionController::class, 'create']);
            Route::put('/{id}', [TransactionController::class, 'update']);
            Route::delete('/{id}', [TransactionController::class, 'delete']);
    
            Route::get('summary', [TransactionController::class, 'getSummary']);
        });
    
        Route::group([
            'prefix' => 'categories',
        ], function () {
            Route::get('', [CategoryController::class, 'index']);
            Route::post('', [CategoryController::class, 'create']);
            Route::get('/by-name/{name}', [CategoryController::class, 'getByName']);
            Route::get('/{id}', [CategoryController::class, 'show']);
            Route::delete('/{id}', [CategoryController::class, 'delete']);
            Route::put('/{id}', [CategoryController::class, 'update']);
        });
    });
});
