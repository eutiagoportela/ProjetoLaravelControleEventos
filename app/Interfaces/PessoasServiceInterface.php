<?php

namespace App\Interfaces;
use Illuminate\Http\Request;


interface PessoasServiceInterface
{
    public function RegistrosPessoas();
    public function Salvar(Request $request);
    public function Atualizar(Request $request, $id);
    public function RetornaPessoa($id);
    public function Deletar($id);
}