<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AuthorServiceInterface;
use App\Http\Requests\AuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    protected AuthorServiceInterface $authorService;
    public function __construct(AuthorServiceInterface $authorService)
    {
      $this->authorService = $authorService;
    }
    public function index()
    {
        $data = $this->authorService->paginate(10);
        return AuthorResource::collection($data);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthorRequest $request)
    {
        $data = $this->authorService->create($request->validated());
        return new AuthorResource($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data =$this->authorService->find($id);
        return new AuthorResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuthorRequest $request, Author $author)
    {
        $data = $this->authorService->update($author->id, $request->validated());
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $data = $this->authorService->delete($author->id);
        return $data;
    }
}
