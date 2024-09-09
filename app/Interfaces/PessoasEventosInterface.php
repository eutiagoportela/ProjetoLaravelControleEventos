<?php

namespace App\Interfaces;
use Illuminate\Http\Request;
use App\Models\PessoasEventos;

interface PessoasEventosInterface
{
    public function RegistrosPessoasEventos();
    public function Salvar(Request $request);
    public function Deletar(PessoasEventos $pessoasEvento);
}