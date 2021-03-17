<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CategoryCollection
     */
    public function index()
    {
        $categories = Category::with('books')->get(['id', 'title', 'created_at', 'updated_at']);
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
        return Category::create([
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
        return new CategoryResource($category->load('books'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return Response
     */
    public function update(Request $request, Category $category)
    {
        return $category->updade([
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
            $r = $category->books()->count() > 0 ? $category->books()->detach() : true;
            $m = $category->delete();
            return $r && $m;
        });
        if ($deleted) {
            return response('Deleted', 204)->header('Content-Type', 'text/plain');
        }
        abort(404);
    }
}
