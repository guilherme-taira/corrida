<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DadosDoAtleta extends Model
{
    use HasFactory;

    protected $table = 'dados_dos_atletas';

    protected $fillable = [
        'nome',
        'distancia',
        'data_nascimento',
        'sexo',
        'equipe',
        'corrida_id',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    // Relacionamento com a corrida (opcional)
    public function corrida()
    {
        return $this->belongsTo(Corridas::class);
    }
}
