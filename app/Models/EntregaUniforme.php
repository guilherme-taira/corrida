<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaUniforme extends Model
{
    use HasFactory;

    protected $table = 'entrega_uniformes';

    protected $fillable = [
        'corrida_id',
        'cpf',
        'entregue_em'
    ];
}
