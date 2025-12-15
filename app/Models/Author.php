<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    /** @use HasFactory<\Database\Factories\AuthorFactory> */
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'name',
        'bio',
        'nationality'
    ];
    public function books(){
        return $this->hasMany(Book::class);
    }
}
