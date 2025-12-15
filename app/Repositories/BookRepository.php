<?php

namespace App\Repositories;

use App\Contracts\Repositories\AuthorRepositoryInterface;
use App\Contracts\Repositories\BookRepositoryInterface;
use App\Models\Book;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    public function __construct(Book $book)
    {
        $this->setModel($book);
    }

    
}
