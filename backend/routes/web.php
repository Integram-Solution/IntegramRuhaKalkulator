<?php

use App\Http\Controllers\IntegramController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
