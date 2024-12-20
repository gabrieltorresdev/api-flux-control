<?php

use App\Http\Controllers\TransactionCategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v1',
], function () {
    Route::group([
        'prefix' => 'users',
    ], function () {
        Route::get('/', [UserController::class, 'index']);
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
        'prefix' => 'transactions-categories',
    ], function () {
        Route::get('', [TransactionCategoryController::class, 'index']);
        Route::post('', [TransactionCategoryController::class, 'create']);
        Route::get('/by-name/{name}', [TransactionCategoryController::class, 'getByName']);
        Route::delete('/{id}', [TransactionCategoryController::class, 'delete']);
        Route::put('/{id}', [TransactionCategoryController::class, 'update']);
    });
});
