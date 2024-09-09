<?php

namespace App\Repositories;
use App\Interfaces\PessoasServiceInterface;
use App\Models\Pessoas;
use Illuminate\Http\Request;

class PessoasRepository implements PessoasServiceInterface
{
    private $pessoasGlobal;

    public function __construct()
    {
        $this->pessoasGlobal = new Pessoas();
    }

    public function RegistrosPessoas()
    {
        $resultado = $this->pessoasGlobal->with('pessoasEventos.evento')->get()
        ->map(function ($pessoa) { // corrigido o nome da variável
            $pessoa->eventos = $pessoa->pessoasEventos->pluck('evento'); // corrigido o nome da propriedade
            unset($pessoa->pessoasEventos);
            return $pessoa;
        });

        return $resultado;
    }



    public function Salvar(Request $request)
    {
        $request->validate($this->pessoasGlobal->regrasStore(), $this->pessoasGlobal->MensagensRegrasValidacaoStore());
    
        return $this->pessoasGlobal->create([
            'nome' => $request->input('nome'),
            'idade' => $request->input('idade'),
            'cpf' => $request->input('cpf'),
            'localnascimento' => $request->input('localnascimento'),
            'endereco' => $request->input('endereco'),
            'telefone' => $request->input('telefone'),
            'email' => $request->input('email'),
        ]);
    }

    public function Atualizar(Request $request, $id)
    {
        $validator = $request->validate($this->pessoasGlobal->regrasSUpdate(), $this->pessoasGlobal->MensagensRegrasValidacaoUpdate());

        $pessoasBanco = $this->pessoasGlobal->find($id);
        if (!$pessoasBanco) {
            return response()->json(['error' => 'Registro não encontrado'], 404);
        }
        $pessoasBanco->update($request->only($pessoasBanco->getFillable()));
       
        return $affected = $pessoasBanco->update($request->only($pessoasBanco->getFillable()));
       
    }

    public function RetornaPessoa($id)
    {
        return $this->pessoasGlobal->with('pessoasEventos.evento')->find($id);
    }

    public function Deletar($id)
    {
       
            $pessoasBanco = $this->pessoasGlobal->find($id);
            if ($pessoasBanco) {
                $pessoasBanco->delete();
                return true;
            }
            return false;

       
    }
}

