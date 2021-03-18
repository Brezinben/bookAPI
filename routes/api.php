<?php


use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookRelationController;
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
    //Pour les premiere Entitées
    Route::apiResources([
        'authors' => AuthorController::class,
        'books' => BookController::class,
        'categories' => CategoryController::class],
        ['only' => ['index', 'show']]);

    //Pour les relations des livres
    Route::apiResources([
        'authors.books' => BookRelationController::class,
        'books.author' => BookRelationController::class,
        'books.category' => BookRelationController::class,
        'categories.books' => BookRelationController::class],
        ['only' => 'index']);

    //Methods quand on est éditor
    Route::middleware(['auth:sanctum', 'editor'])->group(function () {
        Route::apiResources([
            'authors' => AuthorController::class,
            'books' => BookController::class,
            'categories' => CategoryController::class],
            ['only' => ["store", "update"]]);

        Route::apiResources([
            'authors' => AuthorController::class,
            'books' => BookController::class,
            'categories' => CategoryController::class],
            ['only' => "destroy", "middleware" => 'admin']);
    });
});


