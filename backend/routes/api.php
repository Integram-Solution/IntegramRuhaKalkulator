<?php

use App\Http\Controllers\IntegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/integram', [IntegramController::class, 'index'])->name('integram.index');
Route::post('/integram', [IntegramController::class, 'store'])->name('integram.store');