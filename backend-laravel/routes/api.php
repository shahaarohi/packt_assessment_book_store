<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\BooksController;
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

// Authentication routes //
Route::controller(AuthenticationController::class)->group(function(){
    Route::post('login', 'login');
});

Route::controller(BooksController::class)->group(function(){
    Route::get('books', 'index');
    Route::get('books/{id}', 'show');
});

// Admin accessible route //
Route::middleware('auth:sanctum','admin')->group(function () {
    // Create, Update, Delete book details //
   // Route::resource('books', BooksController::class);
    Route::controller(BooksController::class)->group(function(){
        Route::post('books', 'store');
        Route::post('books/{id}', 'update');
        Route::delete('books/{id}', 'destroy');
    });
});