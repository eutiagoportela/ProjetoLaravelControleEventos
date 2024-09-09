<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('pessoas', 'App\Http\Controllers\PessoasController');
Route::apiResource('eventos', 'App\Http\Controllers\EventosController');
Route::apiResource('pessoaseventos', 'App\Http\Controllers\PessoasEventosController');
Route::apiResource('eventos', 'App\Http\Controllers\EventosController');

Route::get('/eventosfechados/{id?}', 'App\Http\Controllers\EventosController@eventosFechados');
