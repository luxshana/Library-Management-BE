<?php

namespace App\Contracts\Services;

interface BorrowingServiceInterface 
{
    public function create(array $data);
    public function update(String $id ,array $data);
    public function paginate();
    public function delete(String $id );
    public function find(String $id);
    public function returnBook(String $id);
}
