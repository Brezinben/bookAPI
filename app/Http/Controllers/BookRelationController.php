<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BookRelationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Book $book
     * @return BookCollection
     */
    public function index(Book $book)
    {
        dd($book);
    }
}
