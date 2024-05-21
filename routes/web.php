<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/players', [PlayerController::class, 'index']);
Route::get('/players/{id}', 'PlayerController@show');
Route::get('/players/create', 'PlayerController@create');

