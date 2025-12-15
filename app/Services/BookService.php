<?php

namespace App\Services;

use App\Contracts\Repositories\BookRepositoryInterface;
use App\Contracts\Services\BookServiceInterface;

class BookService implements BookServiceInterface
{
    protected BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function create(array $data)
    {
        return $this->bookRepository->create($data);
    }
    public function update(String $id, array $data)
    {
        return $this->bookRepository->update($id, $data);
    }
    public function paginate()
    {
        return $this->bookRepository->paginate();
    }
    public function delete(string $id)
    {
        return $this->bookRepository->delete($id,);
    }
    public function find(String $id)
    {
        return $this->bookRepository->find($id);
    }

     //user when returnBook
    public function returnBook(string $id)
    {
        $data = $this->find($id);
        if ($data->available_copies < $data->total_copies) {
            return $this->update($id, ['available_copies' => $data->available_copies + 1]);
        }
    }
}
