<?php

namespace App\Services;

use App\Contracts\Repositories\MemberRepositoryInterface;
use App\Contracts\Services\MemberServiceInterface;

class MemberService implements MemberServiceInterface
{
    protected MemberRepositoryInterface $memberRepository;

    public function __construct(MemberRepositoryInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function create(array $data)
    {
        return $this->memberRepository->create($data);
    }
    public function update(String $id ,array $data)
    {
        return $this->memberRepository->update($id, $data);
    }
    public function paginate()
    {
       return $this->memberRepository->paginate();
    }
    public function delete(string $id ){
        return $this->memberRepository->delete($id, );
    }
    public function find(String $id){
        return $this->memberRepository->find($id);
    }
}
