<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    // Storage::disk('local')->put('example.txt', 'Contents');
    $contents = Storage::disk('local')->get('example.txt');
    logger($contents);
    return $contents; // Outputs: Contents


});
