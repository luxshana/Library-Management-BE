<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemeberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'=>$this->id,
            'email'=>$this->email,
            'address'=>$this->address,
            'membershp_date'=>$this->membershp_date,
            'status'=>$this->status
        ];
    }
}
