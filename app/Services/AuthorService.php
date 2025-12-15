<?php

namespace App\Services;

use App\Contracts\Repositories\AuthorRepositoryInterface;
use App\Contracts\Services\AuthorServiceInterface;

class AuthorService implements AuthorServiceInterface
{
    protected AuthorRepositoryInterface $authorRepository;

    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function create(array $data)
    {
        return $this->authorRepository->create($data);
    }
    public function update(String $id ,array $data)
    {
        return $this->authorRepository->update($id, $data);
    }
    public function paginate()
    {
       return $this->authorRepository->paginate();
    }
    public function delete(string $id ){
        return $this->authorRepository->delete($id, );
    }
    public function find(String $id){
        return $this->authorRepository->find($id);
    }
}
