<?php

use Illuminate\Support\Facades\Route;
use App\Notifications\NotificacaoEventos;
use App\Repositories\EventosRepository;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/notificacacaoEmail', function () 
{
     $user = App\Models\User::first();

     $repositorioEventos = new EventosRepository();
     $eventos = $repositorioEventos->RegistrosEventosData();
     foreach ($eventos as $evento) {
        foreach ($evento->pessoas as $pessoa) {
            $user->notify(new NotificacaoEventos($evento, $pessoa));
        }
    }
});
