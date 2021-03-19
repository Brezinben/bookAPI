<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class BookRelationController extends Controller
{
    /**
     * Renvoie une des relations des books
     *
     * @param Request $request
     * @param Author|Book|Category $model
     * @return  ResourceCollection|JsonResource|Response
     */
    public function index(Request $request,$model)
    {
        switch ($request->route()->getName()) {
            case "books.category.index":
                return new CategoryResource(Book::findOrFail($model)->category);
            case "books.author.index":
                return new AuthorResource(Book::findOrFail($model)->author);
            case "categories.books.index":
                return new BookCollection(Category::findOrFail($model)->books);
            case "authors.books.index":
                return new BookCollection(Author::findOrFail($model)->books);
            default:
                return response()->noContent();
        }
    }
}
