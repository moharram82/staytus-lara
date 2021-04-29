<?php

use Illuminate\Support\Facades\Route;


/**
 * API Version 1 routes
 */
Route::prefix('v1')->group(function() {
    Route::get('/login', [\App\Http\Controllers\Api\UserController::class, "loginResponse"])->name('login');

    Route::post('/login', [\App\Http\Controllers\Api\UserController::class, "login"]);

    Route::apiResource('menus', \App\Http\Controllers\Api\MenusController::class);

    Route::apiResource('categories', \App\Http\Controllers\Api\CategoriesController::class);

    Route::apiResource('items', \App\Http\Controllers\Api\ItemsController::class);

    Route::post('items/{id}/image', [\App\Http\Controllers\Api\ItemImageController::class, 'store']);

    Route::delete('items/{id}/image', [\App\Http\Controllers\Api\ItemImageController::class, 'destroy']);
});
