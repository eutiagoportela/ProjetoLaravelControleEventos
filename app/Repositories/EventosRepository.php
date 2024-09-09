<?php

namespace App\Repositories;
use App\Interfaces\EventosServiceInterface;
use App\Models\Eventos;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventosRepository implements EventosServiceInterface
{
    private $eventosGlobal;

    /**
     * Cria uma inst ncia da classe Eventos e a armazena na propriedade eventosGlobal
     *
     * @return void
     */
    public function __construct()
    {
        $this->eventosGlobal = new Eventos();
    }

    public function RegistrosEventos()
    {
        $eventos = $this->eventosGlobal->with('pessoasEventos.pessoa')->get();
    
        $resultados = $eventos->map(function ($evento) {
            $evento->pessoas = $evento->pessoasEventos->pluck('pessoa');
            unset($evento->pessoasEventos);
            return $evento;
        });
    
        return $resultados;
    }

    public function RegistrosEventosData()
    {
        $dataAtual = Carbon::now()->setTimezone('America/Sao_Paulo')->format('Y-m-d');
    
        $eventos = $this->eventosGlobal->with('pessoasEventos.pessoa')->get();
    
        $resultados = $eventos->map(function ($evento) {
            $evento->pessoas = $evento->pessoasEventos->pluck('pessoa');
            unset($evento->pessoasEventos);
            return $evento;
        });
    
        $eventosComDataAtual = $resultados->filter(function ($evento) use ($dataAtual) {
            return Carbon::parse($evento->data)->format('Y-m-d') == $dataAtual;
        });
     //   dd($eventosComDataAtual);
        return $eventosComDataAtual;
    }

    public function Salvar(Request $request)
    {
        $validator = $request->validate($this->eventosGlobal->regrasStore(), $this->eventosGlobal->MensagensRegrasValidacaoStore());

        return  $this->eventosGlobal->create([
            'local' => $request->input('local'),
            'data' => $request->input('data'),
            'qtdingressos' => $request->input('qtdingressos'),
            'valoringressos' => $request->input('valoringressos'),
        ]);
    }

    public function Atualizar(Request $request, $id)
    {
        $validator = $request->validate($this->eventosGlobal->regrasSUpdate(), $this->eventosGlobal->MensagensRegrasValidacaoUpdate());

        $eventosBanco = $this->eventosGlobal->find($id);
        if (!$eventosBanco) {
            return response()->json(['error' => 'Registro não encontrado'], 404);
        }

        if ($request->input('qtdingressos') < $eventosBanco->qtdingressosVendidos) {

            return response()->json(['error' => 'O campo de qtdingressos deve ser maior que o de qtdingressosVendidos, na alteração'], 404);
        }

        $eventosBanco->update($request->only($eventosBanco->getFillable()));
       
       return  $eventosBanco->update($request->only($eventosBanco->getFillable()));
   
    }

    public function RetornaEvento($id)
    {
        $evento = $this->eventosGlobal->find($id);
        $evento->total = $evento->qtdingressosVendidos * $evento->valoringressos;
        return  $evento;
 
    }

    
    public function RetornaEventosFechados()
    {
        $eventosFechados = $this->eventosGlobal
        ->where('status', 0) 
        ->get();

        $eventosComTotais = $eventosFechados->map(function ($evento) {
            $evento->total = $evento->qtdingressosVendidos * $evento->valoringressos;
            return $evento;
        });
        return $eventosComTotais;
    }

    public function Deletar($id)
    {
       
            $pessoasBanco = $this->eventosGlobal->find($id);
            if ($pessoasBanco) {
                $pessoasBanco->delete();
                return true;
            }
            return false;

       
    }
}

