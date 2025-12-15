<?php

namespace App\Http\Controllers;

use App\Contracts\Services\BookServiceInterface;
use App\Http\Requests\StoreBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected BookServiceInterface $bookService;
    public function __construct(BookServiceInterface $bookService)
    {
        $this->bookService = $bookService;
    }
    public function index(Request $request)
    {
        $books = $this->bookService->paginate(10);
        // logger($books);
        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $book = $this->bookService->create($request->validated());

        $book->load('author');
        return new BookResource($book);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book = $this->bookService->find($book->id);
        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBookRequest $request, Book $book)
    {
        $data = $this->bookService->update($book->id, $request->validated());
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $data = $this->bookService->delete($book->id);
        return $data;
    }
}
