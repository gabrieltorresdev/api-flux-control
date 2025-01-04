<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Test route for Keycloak authentication
Route::get('/auth-test', function () {
    $token = request()->bearerToken();

    return response()->json([
        'message' => 'Successfully authenticated',
        'token_info' => [
            'exists' => !empty($token),
            'length' => strlen($token ?? ''),
        ],
        'user' => request()->user(),
        'request_headers' => request()->headers->all(),
    ]);
})->middleware('keycloak');

Route::group([
    'prefix' => 'v1',
    // 'middleware' => ['keycloak']
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
        'prefix' => 'categories',
    ], function () {
        Route::get('', [CategoryController::class, 'index']);
        Route::post('', [CategoryController::class, 'create']);
        Route::get('/by-name/{name}', [CategoryController::class, 'getByName']);
        Route::delete('/{id}', [CategoryController::class, 'delete']);
        Route::put('/{id}', [CategoryController::class, 'update']);
    });
});
