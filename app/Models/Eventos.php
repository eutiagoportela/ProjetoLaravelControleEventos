<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;

class Eventos extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'local',
        'data',
        'qtdingressos',
        'valoringressos',
    ];

    public function regrasStore() {
        return [
          'local' => 'required|filled|string|max:100',
                'data' => 'filled|date_format:Y-m-d H:i:s',
                'qtdingressos' => 'required|filled|integer',
                'valoringressos' => 'required|filled|numeric',
        ];
    }

    public function MensagensRegrasValidacaoStore() {
        return [
            'local.required' => 'O campo local é obrigatório.',
            'local.filled' => 'O campo local não pode ser vazio.',
            'local.max' => 'O campo local deve conter no máximo 100 caracteres.',

            'data.required' => 'O campo data é obrigatório.',
            'data.filled' => 'O campo data não pode ser vazio.',
            'data.date_format' => 'O campo data deve ser uma data válida no formato Ano-Mes-Dia hh:mm:ss.',

            'qtdingressos.required' => 'O campo qtdingressos é obrigatório.',
            'qtdingressos.filled' => 'O campo qtdingressos não pode ser vazio.',
            'qtdingressos.integer' => 'O campo qtdingressos deve ser um número inteiro.',

            'valoringressos.required' => 'O campo valoringressos é obrigatório.',
            'valoringressos.filled' => 'O campo valoringressos não pode ser vazio.',
            'valoringressos.numeric' => 'O campo valoringressos deve ser um valor real.',
        ];
    }

    public function regrasSUpdate() {
        return [
       'local' => 'filled|string|max:100',
                'data' => 'filled|date_format:Y-m-d H:i:s',
                'qtdingressos' => 'filled|integer',
                'valoringressos' => 'filled|numeric',
        ];
    }

    public function MensagensRegrasValidacaoUpdate() {
        return [
            'local.filled' => 'O campo local não pode ser vazio.',
            'local.max' => 'O campo local deve conter no máximo 100 caracteres.',

            'data.filled' => 'O campo data não pode ser vazio.',
            'data.date_format' => 'O campo data deve ser uma data válida no formato Ano-Mes-Dia hh:mm:ss.',

            'qtdingressos.filled' => 'O campo qtdingressos não pode ser vazio.',
            'qtdingressos.integer' => 'O campo qtdingressos deve ser um número inteiro.',

            'valoringressos.filled' => 'O campo valoringressos não pode ser vazio.',
            'valoringressos.numeric' => 'O campo valoringressos deve ser um valor real.',
        ];
    }

    public function pessoas()
    {
        return $this->belongsToMany(Pessoas::class, 'pessoas');
    }

    public function pessoasEventos()
    {
        return $this->hasMany(PessoasEventos::class, 'evento_id', 'id');
    }
}
