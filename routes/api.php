<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InventoryTransactionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserManageController;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('healthcheck', function(){
    return response()->json([
        'status' => 'success',
        'message' => 'API is working',
        'data'   => [],
        'errors' => []
    ]);
});

Route::prefix('auth')->group(function(){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('password/forget_password', [PasswordController::class, 'forgetPassword'])->name('forget_password');
    Route::post('password/password_reset', [PasswordController::class, 'passwordReset'])->name('password_reset');
});



Route::middleware('auth:api')->group(function(){

    Route::prefix('users')->group(function(){
        Route::post('/', [UserManageController::class, 'createUser']);
    });


    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('inventory-transactions', InventoryTransactionController::class);

});



Route::fallback(function(){
    return response()->json([
        'status' => 'error',
        'message' => 'API Endpoint not found',
    ]);
});