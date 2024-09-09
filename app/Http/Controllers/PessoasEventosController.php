<?php

namespace App\Http\Controllers;

use App\Models\PessoasEventos;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use App\Repositories\PessoasEventosRepository;

class PessoasEventosController extends Controller
{
    private $pessoaseventosRepository;

    public function __construct(PessoasEventosRepository $pessoaseventosRepository)
    {
        $this->pessoaseventosRepository = $pessoaseventosRepository;
    }

    public function index()
    {

        $pessoasEventos = $this->pessoaseventosRepository->RegistrosPessoasEventos();
        if ($pessoasEventos->count() == 0) {
            return response()->json(['message' => 'Não há registros de pessoas'], 404);
        }
        return response()->json($pessoasEventos, 200);
    }

    public function store(Request $request)
    {
        try {
            $result = $this->pessoaseventosRepository->Salvar($request);
            return $result;
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Dados inválidos',
                'messages' => $e->errors(),
            ], 422);
        }
    }

    public function destroy(PessoasEventos $pessoasEvento)
    {
        try {
            $result = $this->pessoaseventosRepository->Deletar($pessoasEvento);
            
            return $result;
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao excluir registro: ' . $e->getMessage()], 500);
        }
    }
}



   