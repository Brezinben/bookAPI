<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return BookCollection
     */
    public function index()
    {
        $books = Book::with(['category', 'author'])->latest( 'publish_date')->get(['id', 'title', 'status', 'publish_date', 'created_at', 'updated_at', 'category_id', 'author_id']);
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
        $request->validate([
            'title' => 'required|max:255|string',
            'release_date' => 'required|date',
            'status' => [
                'required',
                Rule::in(['disponible', 'en_approvisionnement', 'non_édité']),
            ],
            'category' => 'required|exists:App\Models\Category,id',
            'author' => 'required|exists:App\Models\Author,id',
        ]);
        echo ("ok");

        $book = Book::create([
            'id' => Str::uuid(),
            'title' => $request->title,
            'publish_date' => $request->release_date,
            'status' => $request->status,
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
        $request->validate([
            'title' => 'required|max:255|string',
            'publish_date' => 'required|date',
            'status' => [
                'required',
                Rule::in(['disponible', 'en_approvisionnement', 'non_édité']),
            ],
            'category_id' => 'required|exists:App\Models\Category,id',
            'author_id' => 'required|exists:App\Models\Author,id',
        ]);

        $book->update([
            'id' => $book->id,
            'title' => $request->title,
            'publish_date' => $request->publish_date,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'author_id' => $request->author_id
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
