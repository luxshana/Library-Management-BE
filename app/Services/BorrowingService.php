<?php

namespace App\Services;

use App\Contracts\Repositories\BookRepositoryInterface;
use App\Contracts\Repositories\BorrowingRepositoryInterface;
use App\Contracts\Services\BookServiceInterface;
use App\Contracts\Services\BorrowingServiceInterface;

class BorrowingService implements BorrowingServiceInterface
{
    protected BorrowingRepositoryInterface $borrowingRepository;
    protected BookServiceInterface $bookService;

    public function __construct(BorrowingRepositoryInterface $borrowingRepository, BookServiceInterface $bookService)
    {
        $this->borrowingRepository = $borrowingRepository;
        $this->bookService = $bookService;
    }

    public function create(array $data)
    {
        return $this->borrowingRepository->create($data);
    }
    public function update(String $id, array $data)
    {
        return $this->borrowingRepository->update($id, $data);
    }
    public function paginate()
    {
        return $this->borrowingRepository->paginate();
    }
    public function delete(string $id)
    {
        return $this->borrowingRepository->delete($id,);
    }
    public function find(String $id)
    {
        return $this->borrowingRepository->find($id);
    }
    public function returnBook(String $id)
    {
        $data = $this->find($id);
       
       
        $this->update($id, [
            'status' => 'returned',
            'returned_date' => now()
        ]);
        $this->bookService->returnBook($data->book_id);
        return $this->find($id);
    }
}
