<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BooksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    // admin only routes
    Route::prefix('books')->middleware('checkrole:admin')->group(function () {
        Route::post('/storeBook', [BooksController::class, 'storeBook']);
        Route::put('/updateBook/{iBookId}', [BooksController::class, 'updateBook']);
        Route::delete('/destroyBook/{iBookId}', [BooksController::class, 'destroyBook']);
    });

    // user and admin routes
    Route::prefix('books')->middleware('checkrole:admin,user')->group(function () {
        Route::get('/getAllBooks', [BooksController::class, 'getAllBooks']);
        Route::get('/getBook/{iBookId}', [BooksController::class, 'getBook']);
    });
});

Route::prefix('auth')->group(function() {
    Route::post('/registerUser', [AuthController::class, 'registerUser']);
    Route::post('/loginUser', [AuthController::class, 'loginUser']);
    Route::post('/logoutUser', [AuthController::class, 'logoutUser'])->middleware('auth:sanctum');
    Route::get('/getUser', [AuthController::class, 'getUser']);
});
