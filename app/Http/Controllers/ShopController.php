<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function home()
    {
        $books = Book::where('is_active', true)
            ->with(['images', 'authors'])
            ->latest()
            ->take(8)
            ->get();

        return view('shop.home', compact('books'));
    }

    public function index(Request $request)
    {
        $search = $request->string('q')->trim()->toString();
        $sort = $request->string('sort')->toString();
        $category = $request->string('category')->toString();

        $query = Book::where('is_active', true)->with(['images', 'authors']);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('authors', fn ($a) => $a->where('name', 'like', "%{$search}%"));
            });
        }

        if ($category !== '') {
            $query->whereHas('categories', fn ($c) => $c->where('slug', $category));
        }

        match ($sort) {
            'price_asc' => $query->orderBy('price_cents'),
            'price_desc' => $query->orderByDesc('price_cents'),
            'title' => $query->orderBy('title'),
            default => $query->latest(),
        };

        $books = $query->paginate(12)->withQueryString();

        $categories = Category::whereHas('books', fn ($b) => $b->where('is_active', true))
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return view('shop.index', compact('books', 'search', 'sort', 'category', 'categories'));
    }

    public function show(Book $book)
    {
        abort_unless($book->is_active, 404);

        $book->load(['images', 'authors']);

        $related = Book::where('is_active', true)
            ->where('id', '!=', $book->id)
            ->with('images')
            ->take(4)
            ->get();

        return view('shop.show', compact('book', 'related'));
    }
}