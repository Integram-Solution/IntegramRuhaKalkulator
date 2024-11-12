<?php

use App\Http\Controllers\IntegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/integram', [IntegramController::class, 'index'])->name('integram.index');
Route::post('/integram', [IntegramController::class, 'store'])->name('integram.store');
Route::get('/integram/{id}', [IntegramController::class, 'show'])->name('integram.show'); 
Route::put('/integram/{id}', [IntegramController::class, 'update'])->name('integram.update'); 
Route::delete('/integram/{id}', [IntegramController::class, 'destroy'])->name('integram.destroy'); 