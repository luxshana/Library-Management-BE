<?php

namespace App\Repositories;

use App\Contracts\Repositories\AuthorRepositoryInterface;
use App\Contracts\Repositories\BookRepositoryInterface;
use App\Contracts\Repositories\MemberRepositoryInterface;
use App\Models\Book;
use App\Models\Member;

class MemberRepository extends BaseRepository implements MemberRepositoryInterface
{
    public function __construct(Member $member)
    {
        $this->setModel($member);
    }

    
}
