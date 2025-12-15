<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//authors
Route::post('/authors', [AuthorController::class,'store']);
Route::get('/authors',[AuthorController::class,'index']);
Route::patch('/authors/{author}',[AuthorController::class,'update']);
Route::get('/authors/{author}',[AuthorController::class,'show']);
Route::delete('/authors/{author}',[AuthorController::class,'destroy']);
// Route::post('/authors',[BookController::class,'']);
//Books
Route::get('/books',[BookController::class, 'index']);
Route::post('/books',[BookController::class, 'store']);
Route::patch('/books/{book}',[BookController::class, 'update']);
Route::get('/books/{book}',[BookController::class, 'show']);
Route::delete('/books/{book}',[BookController::class, 'destroy']);

//Members
Route::get('/members',[MemberController::class,'index']);
Route::post('/members',[MemberController::class,'store']);
Route::patch('/members/{member}',[MemberController::class,'update']);
Route::delete('/members/{member}',[MemberController::class,'destroy']);
Route::get('/members/{member}',[MemberController::class,'show']);

//borrowings
Route::get('/borrow',[BorrowingController::class,'index']);
Route::post('/borrow',[BorrowingController::class,'store']);
Route::patch('/borrow',[BorrowingController::class,'update']);
Route::delete('/borrow',[BorrowingController::class,'destroy']);
Route::get('/borrow/{borrowing}',[BorrowingController::class,'show']);
Route::get('/borrow/returnBook/{id}',[BorrowingController::class,'returnBook']);
// Route::get('/borrow',[BorrowingController::class,'show']);