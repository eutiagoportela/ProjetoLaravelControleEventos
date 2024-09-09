<?php

namespace App\Repositories;


use App\Models\PessoasEventos;
use Illuminate\Http\Request;
use App\Models\Eventos;
use Carbon\Carbon;

class PessoasEventosRepository
{
    private $pessoaseventosGlobal;

    public function __construct()
    {
        $this->pessoaseventosGlobal = new PessoasEventos();
    }

    public function RegistrosPessoasEventos()
    {
        return $this->pessoaseventosGlobal->with('pessoa', 'evento')->get();
   
    }

    public function Salvar(Request $request)
    {
        $request->validate($this->pessoaseventosGlobal->regrasStore(), $this->pessoaseventosGlobal->MensagensRegrasValidacaoStore());
        $evento = Eventos::find($request->input('evento_id'));
        if ($evento->status ==0) {
            // Retorne uma mensagem de erro
            return response()->json(['error' => 'O evento informado esta fechado, provavelmente esta em andamento ou foi já foi realizado'], 422);
        }

        // Verificar se a data atual é maior que uma hora de diferença da data do evento, se for menor fecha o evento ao inserir
        $dataAtual = Carbon::now('America/Sao_Paulo');
        $dataAtual =  Carbon::createFromFormat('Y-m-d H:i:s', $dataAtual->format('Y-m-d H:i:s'));
        $dataEvento = Carbon::parse($evento->data);
        $diferenca = $dataAtual->diffInMinutes($dataEvento);

       // dd($diferenca);
        if ($diferenca <=60) {
            $evento->status = 0;
            $evento->update();

            return [
                'error' => 'O evento está prestes a começar ou já começou'.'  Atual: '.$dataAtual.'  -  Evento:'.$dataEvento. '  diferença: '.$diferenca.' minutos',
                'status' => 422,
            ];
        }


        // Verificar se o pessoa_id e evento_id já não existem gravados e vinculados em pessoaseventos
        $existingPessoaEvento = $this->pessoaseventosGlobal->where('pessoa_id', $request->input('pessoa_id'))
            ->where('evento_id', $request->input('evento_id'))
            ->first();

      
        if ($existingPessoaEvento) {
            return [
                'error' => 'Já existe um registro com essa combinação de pessoa_id e evento_id,pessoa ja cadastrada nesse evento',
                'status' => 422,
            ];
        }

        // Verificar se o qtdingressos do evento é maior que 0
        if ($evento->qtdingressosVendidos == $evento->qtdingressos) {
            return [
                'error' => 'Não há ingressos disponíveis para esse evento',
                'status' => 422,
            ];
        }


        // incrementar o campo qtdingressosVendidos do modelo Eventos em -1
        $evento->increment('qtdingressosVendidos', 1);

        $pessoaevento = $this->pessoaseventosGlobal->create([
            'pessoa_id' => $request->input('pessoa_id'),
            'evento_id' => $request->input('evento_id'),
        ]);

        return [
            'data' => $pessoaevento,
            'status' => 201,
        ];
    }


    public function Deletar(PessoasEventos $pessoasEvento)
    {
        if (!$this->pessoaseventosGlobal->where('pessoa_id', $pessoasEvento->pessoa_id)->exists()) {
            return [
                'message' => 'Usuário não encontrado com o ID!',
                'status' => 404,
            ];
        }
    
        if (!$this->pessoaseventosGlobal->where('evento_id', $pessoasEvento->evento_id)->exists()) {
            return [
                'message' => 'Evento não encontrado com o ID!',
                'status' => 404,
            ];
        }
    
        try {
            $pessoasEvento->delete();
            return [
                'message' => 'Registro excluído com sucesso!',
                'status' => 200,
            ];
        } catch (\Exception $e) {
            return [
                'message' => 'Erro ao excluir o registro!',
                'status' => 500,
            ];
        }
    }
}

