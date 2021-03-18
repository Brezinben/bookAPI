<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthorCollection;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AuthorCollection
     */
    public function index()
    {
        $authors = Author::with('books')->get(['id', 'first_name', 'last_name', 'birth_date', 'death_date', 'created_at', 'updated_at']);
        return new AuthorCollection($authors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        return Author::create([
            'id' => Str::uuid(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birth_date' => $request->birth_date,
            'death_date' => $request->death_date,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Author $author
     * @return AuthorResource
     */
    public function show(Author $author)
    {
        return new AuthorResource($author->load(['books' => fn($query) => $query->orderBy('publish_date', 'asc')]));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Author $author
     * @return bool
     */
    public function update(Request $request, Author $author)
    {
        return $author->update([
            'id' => $author->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birth_date' => $request->birth_date,
            'death_date' => $request->death_date,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Author $author
     * @return Response
     */
    public function destroy(Author $author)
    {
        $deleted = DB::transaction(function () use ($author) {
            if ($author->books()->count() > 0) {
                return false;
            }
            return $author->delete();
        });
        if ($deleted) {
            return response('Deleted', 204)->header('Content-Type', 'text/plain');
        }
        abort(404, "Erreur lors de la suppression");
    }
}
