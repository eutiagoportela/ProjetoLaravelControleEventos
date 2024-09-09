<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'idade',
        'cpf',
        'localnascimento',
        'endereco',
        'telefone',
        'email',
    ];

    public function regrasStore() {
        return [
            'nome' => 'required|filled|string|max:50|unique:pessoas',
            'idade' => 'required|filled|integer',
            'cpf' => 'required|filled|string|max:11',
            'localnascimento' => 'required|filled|string|max:80',
            'endereco' => 'nullable|string|max:150',
            'telefone' => 'nullable|string|max:15',
            'email' => 'nullable|string|max:150|unique:pessoas',
        ];
    }

    public function MensagensRegrasValidacaoStore() {
        return [
        'nome.required' => 'O campo nome é obrigatório.',
                'nome.filled' => 'O campo nome não pode ser vazio.',
                'nome.max' => 'O campo nome deve conter no máximo 50 caracteres.',

                'idade.required' => 'O campo idade é obrigatório.',
                'idade.filled' => 'O campo idade não pode ser vazio.',
                'idade.integer' => 'O campo idade deve ser um número inteiro.',

                'cpf.required' => 'O campo CPF é obrigatório.',
                'cpf.filled' => 'O campo CPF não pode ser vazio.',
                'cpf.max' => 'O campo CPF deve conter no máximo 11 caracteres.',

                'localnascimento.required' => 'O campo local de nascimento é obrigatório.',
                'localnascimento.filled' => 'O campo local de nascimento não pode ser vazio.',
                'localnascimento.max' => 'O campo local de nascimento deve conter no máximo 80 caracteres.',

                'endereco.max' => 'O campo endereço deve conter no máximo 150 caracteres.',
                'telefone.max' => 'O campo telefone deve conter no máximo 15 caracteres.',
                'email.max' => 'O campo e-mail deve conter no máximo 150 caracteres.',
        ];
    }

    public function regrasSUpdate() {
        return [
            'nome' => 'filled|string|max:50|unique:pessoas',
            'idade' => 'filled|integer',
            'cpf' => 'filled|string|max:11',
            'localnascimento' => 'filled|string|max:80',
            'endereco' => 'nullable|string|max:150',
            'telefone' => 'nullable|string|max:15',
            'email' => 'nullable|string|max:150|unique:pessoas',
        ];
    }

    public function MensagensRegrasValidacaoUpdate() {
        return [
            'nome.filled' => 'O campo nome não pode ser vazio.',
            'nome.max' => 'O campo nome deve conter no máximo 50 caracteres.',

            'idade.filled' => 'O campo idade não pode ser vazio.',
            'idade.integer' => 'O campo idade deve ser um número inteiro.',

            'cpf.filled' => 'O campo CPF não pode ser vazio.',
            'cpf.max' => 'O campo CPF deve conter no máximo 11 caracteres.',

            'localnascimento.filled' => 'O campo local de nascimento não pode ser vazio.',
            'localnascimento.max' => 'O campo local de nascimento deve conter no máximo 80 caracteres.',

            'endereco.max' => 'O campo endereço deve conter no máximo 150 caracteres.',
            'telefone.max' => 'O campo telefone deve conter no máximo 15 caracteres.',
            'email.max' => 'O campo e-mail deve conter no máximo 150 caracteres.',
        ];
    }

    public function eventos()
    {
        return $this->belongsToMany(Eventos::class, 'eventos');
    }

    public function pessoasEventos()
    {
        return $this->hasMany(PessoasEventos::class, 'pessoa_id', 'id');
    }
}
