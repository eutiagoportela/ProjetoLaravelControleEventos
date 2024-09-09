<?php

namespace App\Http\Controllers;

use App\Repositories\PessoasRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PessoasController extends Controller
{
    private $pessoasRepository;

    public function __construct(PessoasRepository $pessoasRepository)
    {
        $this->pessoasRepository = $pessoasRepository;
    }

    public function index()
    {
        $pessoas = $this->pessoasRepository->RegistrosPessoas();
    
        if ($pessoas->count() == 0) {
            return response()->json(['message' => 'Não há registros de pessoas'], 404);
        }
    
        return response()->json($pessoas, 200);
    }


    public function store(Request $request)
    {
        try {
            $pessoa = $this->pessoasRepository->Salvar($request);
            return response()->json([
                'message' => 'Dados gravados com sucesso!',
                'pessoa' => $pessoa,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Dados inválidos',
                'messages' => $e->errors(),
            ], 422);
        }
    }

    public function show($id = null)
    {
        if ($id) {
            $pessoasBanco = $this->pessoasRepository->RetornaPessoa($id);
            if ($pessoasBanco) {
                return response()->json($pessoasBanco, 200);
            } else {
                return response()->json(['message' => 'Registro não encontrado'], 404);
            }
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $affected = $this->pessoasRepository->Atualizar($request,$id);
 
            if ($affected > 0) {
                return response()->json([
                    'message' => 'Dados alterados com sucesso!',
                ], 200);
            } else {
                return response()->json([
                    'error' => 'Atualização não realizada',
                    'Pessoa' => $request,
                ], 422);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Dados inválidos',
                'messages' => $e->errors(),
            ], 422);
        }
    }


    public function destroy($id)
    {
        try {
            $resposta = $this->pessoasRepository->Deletar($id);
            if($resposta)
              return response()->json(['message' => 'Registro excluído com sucesso!'], 200);
            else
              return response()->json(['message' => 'Registro não encontrado'], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao excluir registro: ' . $e->getMessage()], 500);
        }
    }
}
