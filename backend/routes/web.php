<?php

use App\Http\Controllers\IntegramController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get("/integram", [IntegramController::class, "index"])->name("integram.index");
