<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use App\Models\Eventos;
use Illuminate\Support\Facades\Log;

class AtualizarStatusEvento implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Get the current server time
        $dataAtual = Carbon::now()->setTimezone('America/Sao_Paulo');


        Eventos::whereRaw('TIMESTAMP(data) - INTERVAL 1 HOUR <= TIMESTAMP(?)', [$dataAtual])
        ->where('status', 1)
        ->update(['status' => 0]);

        Log::info('Evento alterado.'.$dataAtual);
    }
}
