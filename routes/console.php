<?php


use Illuminate\Support\Facades\Schedule;
use App\Jobs\AtualizarStatusEvento;


Schedule::job(new AtualizarStatusEvento())->everyMinute();
