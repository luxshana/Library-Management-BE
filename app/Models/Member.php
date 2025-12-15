<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'address',
        'membershp_date',
        'status'
    ];
    protected $casts = [
        'membershp_date'=>'date'
    ];
    public function borrowings(){
        return $this->hasMany(Borrowing::class);
    }
    public function activeBorrowings(){
        return $this->borrowings()->where('status','borrowed');
    }
}
