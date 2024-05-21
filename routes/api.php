<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PlayerController;
use App\Http\Controllers\API\ManagerController;
use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\ChampionshipController;
use App\Http\Controllers\API\GameController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Rotas para o jogador
Route::get('/jogador', [PlayerController::class, 'index']);

//Rotas para o treinador
Route::get('/treinador', [ManagerController::class, 'index']);
Route::post('/treinadorAdd', [ManagerController::class, 'store']);

//Rotas para o time
Route::get('/time', [TeamController::class, 'index']);

//Rotas para o campeonato
Route::get('/campeonato', [ChampionshipController::class, 'index']);

//Rotas para o jogo
Route::get('/process-round', [GameController::class, 'processRound']);
