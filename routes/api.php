<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatementController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
});

Route::middleware(['auth:api'])->group(function () {

    Route::prefix('user')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/{user}', 'get')->name('get')->where(['user' => '[0-9]+']);
            Route::put('/update', 'update')->name('update');
            Route::delete('/remove', 'remove')->name('remove')->middleware('role:admin');
        });
    });

    Route::prefix('statement')->group(function () {
        Route::controller(StatementController::class)->group(function () {
            Route::get('/{statement}', 'get')->name('get')->where(['statement' => '[0-9]+']);
            Route::post('/', 'store')->name('store');
            Route::post('/update/{statement}', 'update')->name('update')->where(['statement' => '[0-9]+']);
            Route::delete('/remove/{statement}', 'remove')->name('remove')->where(['statement' => '[0-9]+']);
        });
    });

});



