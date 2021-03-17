<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return BookCollection
     */
    public function index()
    {
        $books = Book::with(['category', 'author'])->get(['id', 'title', 'status', 'publish_date', 'created_at', 'updated_at', 'category_id', 'author_id']);
        return new BookCollection($books);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return BookResource
     */
    public function store(Request $request)
    {
        $book = Book::create([
            'id' => Str::uuid(),
            'title' => $request->title,
            'publish_date' => $request->release_date,
            'status' => $request->release_date,
            'category_id' => $request->category,
            'author_id' => $request->author
        ]);
        return $book;
    }

    /**
     * Display the specified resource.
     *
     * @param Book $book
     * @return BookResource
     */
    public function show(Book $book)
    {
        return new BookResource($book->load('author', 'category'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Book $book
     * @return Book
     */
    public function update(Request $request, Book $book)
    {
        $book->update([
            'id' => Str::uuid(),
            'title' => $request->title,
            'publish_date' => $request->release_date,
            'status' => $request->release_date,
            'category_id' => $request->category,
            'author_id' => $request->author
        ]);
        return $book;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Book $book
     * @return Response
     */
    public function destroy(Book $book): Response
    {
        $deleted = false;

        try {
            $deleted = $book->delete();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        if ($deleted) {
            return response('Deleted', 204)->header('Content-Type', 'text/plain');
        }
        abort(404);
    }
}
