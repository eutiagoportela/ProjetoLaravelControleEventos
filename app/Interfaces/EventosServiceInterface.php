<?php

namespace App\Interfaces;
use Illuminate\Http\Request;


interface EventosServiceInterface
{
    public function RegistrosEventos();
    public function RegistrosEventosData();
    public function Salvar(Request $request);
    public function Atualizar(Request $request, $id);
    public function RetornaEvento($id);
    public function RetornaEventosFechados();
    public function Deletar($id);
}