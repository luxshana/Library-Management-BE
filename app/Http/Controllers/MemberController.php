<?php

namespace App\Http\Controllers;

use App\Contracts\Services\MemberServiceInterface;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Resources\MemeberResource;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    protected MemberServiceInterface $memberService;
    public function __construct(MemberServiceInterface $memberService)
    {
        $this->memberService = $memberService;
    }
    public function index()
    {
        $data = $this->memberService->paginate(10);
        return MemeberResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $request)
    {
        $data = $this->memberService->create($request->validated());
        return new MemeberResource($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        $data = $this->memberService->find($member->id);
        return new MemeberResource( $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMemberRequest $request, Member $member)
    {
        $data = $this->memberService->update($member->id, $request->validated());
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->memberService->delete($id);
        return $data;

    }
}
