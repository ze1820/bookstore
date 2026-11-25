<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::orderBy('name')->get();

        return view('authors.index', compact('authors'));
    }

    public function show(Author $author)
    {
        $books = $author->books()
            ->where('is_active', true)
            ->with(['images', 'authors'])
            ->get();

        return view('authors.show', compact('author', 'books'));
    }
}