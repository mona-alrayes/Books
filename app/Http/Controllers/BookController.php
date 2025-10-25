<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return self::paginated(Book::paginate(10), null, 'Books retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        return self::success(Book::create($request->validated()), 'Book created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return self::success($book, 'Book retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        return self::success($book->update($request->validated()), 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return self::success(null, 'Book deleted successfully.');
    }
}
