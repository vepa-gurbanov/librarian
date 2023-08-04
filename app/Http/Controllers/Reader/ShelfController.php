<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Shelf;
use Illuminate\Http\Request;

class ShelfController extends Controller
{
    public function shelfBooks(string $id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $books = Book::query()
            ->where('shelf_id', $id)
            ->orderByDesc('id')
            ->with('categories:id,name,slug')
            ->paginate(20, ['id', 'shelf_id', 'name', 'slug', 'image', 'price'])
            ->withQueryString();

        $data = [
            'books' => $books,
        ];

        return view('reader.shelf.books')->with($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $shelves = Shelf::query()
            ->withCount('books')
            ->orderBy('sort_order')
            ->get(['id', 'name']);

        $data = [
            'shelves' => $shelves,
        ];

        return view('reader.shelf.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reader.shelf.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
//        $shelf = Shelf::query()->where('id', $id)->with(['reader'])->withCount('books')->get();

        $shelf = Shelf::with('reader')->withCount('books')->findOrFail($id);
//        return $shelf;

        $data = [
            'shelf' => $shelf,
        ];

        return view('reader.shelf.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
