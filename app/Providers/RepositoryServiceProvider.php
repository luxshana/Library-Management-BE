<?php

namespace App\Providers;

use App\Contracts\Repositories\AuthorRepositoryInterface;
use App\Contracts\Repositories\BookRepositoryInterface;
use App\Contracts\Repositories\BorrowingRepositoryInterface;
use App\Contracts\Repositories\MemberRepositoryInterface;
use App\Contracts\Services\AuthorServiceInterface;
use App\Contracts\Services\BookServiceInterface;
use App\Contracts\Services\BorrowingServiceInterface;
use App\Contracts\Services\MemberServiceInterface;
use App\Repositories\AuthorRepository;
use App\Repositories\BookRepository;
use App\Repositories\BorrowingRepository;
use App\Repositories\MemberRepository;
use App\Services\AuthorService;
use App\Services\BookService;
use App\Services\BorrowingService;
use App\Services\MemberService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthorRepositoryInterface::class, AuthorRepository::class);
        $this->app->bind(AuthorServiceInterface::class, AuthorService::class);
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(BookServiceInterface::class, BookService::class);
        $this->app->bind(MemberRepositoryInterface::class, MemberRepository::class);
        $this->app->bind(MemberServiceInterface::class, MemberService::class);
        $this->app->bind(BorrowingRepositoryInterface::class, BorrowingRepository::class);
        $this->app->bind(BorrowingServiceInterface::class, BorrowingService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
