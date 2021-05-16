<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CategoryCollection
     */
    public function index()
    {
        $categories = Category::with('books')->orderBy('title')->get(['id', 'title', 'created_at', 'updated_at']);
        return new CategoryCollection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return CategoryResource
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'bail|required|max:255|string|unique:categories,title',
        ]);
        return Category::create([
            'id' => Str::uuid(),
            'title' => $request->title
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return CategoryResource
     */
    public function show(Category $category)
    {
        return new CategoryResource($category->load(['books' => fn($query) => $query->orderBy('publish_date', 'asc')]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return bool
     */
    public function update(Request $request, Category $category): bool
    {
        $request->validate([
            'title' => 'required|max:255|string',
        ]);
        return $category->update([
            'id' => $category->id,
            'title' => $request->title
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     */
    public function destroy(Category $category)
    {
        $deleted = DB::transaction(function () use ($category) {
            if ($category->books()->count() > 0) {
                return false;
            }
            return $category->delete();
        });
        if ($deleted) {
            return response('Deleted', 204)->header('Content-Type', 'text/plain');
        }
        abort(404, "Erreur lors de la suppression");
    }
}
