<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PessoasEventos extends Model
{
    use HasFactory;

    protected $fillable = [
        'pessoa_id',
        'evento_id',
    ];

    public function regrasStore() {
        return [
            'pessoa_id' => 'exists:pessoas,id',
            'evento_id' => 'exists:eventos,id',
            
        ];
    }
    
    public function MensagensRegrasValidacaoStore() {
        return [
            'pessoa_id.exists' => 'A pessoa informada não existe.',
            'evento_id.exists' => 'O evento informado não existe.',
        ];
    }

    public function pessoa()
    {
        return $this->belongsTo(Pessoas::class, 'pessoa_id', 'id');
    }

    public function evento()
    {
        return $this->belongsTo(Eventos::class, 'evento_id', 'id');
    }
}
