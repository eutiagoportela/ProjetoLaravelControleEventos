<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Repositories\EventosRepository;

class EventosController extends Controller
{
    private $eventosRepository;

    public function __construct(EventosRepository $eventosRepository)
    {
        $this->eventosRepository = $eventosRepository;
    }
    
    public function index()
    {
        $eventos = $this->eventosRepository->RegistrosEventos();
        if ($eventos->count() == 0) {
            return response()->json(['message' => 'Não há registros de eventos'], 404);
        }
        return response()->json($eventos, 200);


    }


    public function store(Request $request)
    {
        try {
            $evento = $this->eventosRepository->Salvar($request);

            return response()->json([
                'message' => 'Dados gravados com sucesso!',
                'Evento' => $evento,
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
            $eventosBanco = $this->eventosRepository->RetornaEvento($id);
            if ($eventosBanco) {
                return response()->json($eventosBanco, 200);
            } else {
                return response()->json(['message' => 'Registro não encontrado'], 404);
            }
        }

    }

    public function eventosFechados($id = null)
    {
        if ($id) {
            $evento = $this->eventosRepository->RetornaEvento($id);
            if ($evento && $evento->status == 1) {
                return response()->json(['message' => 'Evento encontrado porém em aberto'], 404);
            }
            if (!$evento) {
                return response()->json(['message' => 'Evento não encontrado'], 404);
            }
            
            return response()->json($evento, 200);
        } else {
            $eventosFechadosComTotais = $this->eventosRepository->RetornaEventosFechados();

            if ($eventosFechadosComTotais->isEmpty()) {
                return response()->json(['message' => 'Nenhum evento fechado encontrado'], 404);
            }

            return response()->json($eventosFechadosComTotais, 200);
        }
    }

    public function update(Request $request, $id)
    { 
        try {

            $affected = $this->eventosRepository->Atualizar($request,$id);
            if ($affected > 0) {
                        return response()->json([
                            'message' => 'Dados alterados com sucesso!',
                        ], 200);
                    } else {
                        return response()->json([
                            'error' => 'Atualização não realizada',
                            'Evento' => $request,
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
            $resposta = $this->eventosRepository->Deletar($id);
            if($resposta)
              return response()->json(['message' => 'Registro excluído com sucesso!'], 200);
            else
              return response()->json(['message' => 'Registro não encontrado'], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao excluir registro: ' . $e->getMessage()], 500);
        }
    }

    
}
