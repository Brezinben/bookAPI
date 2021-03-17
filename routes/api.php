<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['jsonOnly'])->group(function () {
    Route::apiResource('authors', AuthorController::class)->only(["index", "show"]);
    Route::apiResource('authors.books', AuthorController::class)->only(["index", "show"]);

    Route::apiResource('books', BookController::class)->only(["index", "show"]);
    Route::apiResource('books.author', BookController::class)->only(["index"]);
    Route::apiResource('books.category', BookController::class)->only(["index"]);

    Route::apiResource('categories', CategoryController::class)->only(["index", "show"]);
    Route::apiResource('categories.books', CategoryController::class)->only(["index", "show"]);

    Route::middleware(['auth:sanctum', 'editor'])->group(function () {
        Route::apiResource('authors', AuthorController::class)->only(["store", "update"]);
        Route::apiResource('books', BookController::class)->only(["store", "update"]);
        Route::apiResource('categories', CategoryController::class)->only(["store", "update"]);

        Route::middleware(['admin'])->group(function () {
            Route::apiResource('authors', AuthorController::class)->only('destroy');
            Route::apiResource('books', BookController::class)->only('destroy');
            Route::apiResource('categories', CategoryController::class)->only('destroy');
        });
    });
});


