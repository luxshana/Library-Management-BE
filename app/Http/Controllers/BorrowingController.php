<?php

namespace App\Http\Controllers;

use App\Contracts\Services\BorrowingServiceInterface;
use App\Http\Requests\StoreBorrowingRequest;
use App\Http\Resources\BorrowingResource;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    protected BorrowingServiceInterface $borrowingService;
    public function __construct(BorrowingServiceInterface $borrowingService)
    {
        $this->borrowingService = $borrowingService;
    }
    public function index()
    {
        $data = $this->borrowingService->paginate(5);
        return BorrowingResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBorrowingRequest $request)
    {
        $data = $this->borrowingService->create($request->validated());
        return new BorrowingResource($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        $data = $this->borrowingService->find($borrowing->id);
        return new BorrowingResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
  public function returnBook(String $id){
    $data = $this->borrowingService->find($id);
     if ($data->status !== 'borrowed') {
            return 'Book has alredy been returned';
        }
    return new BorrowingResource($this->borrowingService->returnBook($id));
  }
}
