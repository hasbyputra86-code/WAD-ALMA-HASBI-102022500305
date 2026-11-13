<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TableController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'role:admin,dosen'])->group(function () {
    Route::get('/tables', [TableController::class, 'index']);
});