<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'title',
        'isbn',
        'description',
        'author_id',
        'genre',
        'published_at',
        'total_copies',
        'available_copies',
        'cover_image',
        'price',
        'status '
    ];
    //search function
    public $searchable = ['title'];
    // public $relationable =['author'=> ['id','name']];
    public function author(){
        return $this->belongsTo(Author::class);
    }
    public function borrowings(){
        return $this->hasMany(Borrowing::class);
    }
    //available book
    public function isAvailable(){
        return $this->available_copies > 0;
    }
    //user when borrowed book
    public function borrow(){
        if($this->available_copies > 0) {
            $this->decrement('available_copies');
        }
    }
   
}
