<?php

namespace App\Imports;

use App\Models\DadosDoAtleta;
use App\Models\DadosDosAtleta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DadosAtletasImport implements ToModel, WithHeadingRow
{
    protected $corridaId;

    public function __construct($corridaId)
    {
        $this->corridaId = $corridaId;
    }

    public function model(array $row)
    {
        return new DadosDoAtleta([
            'corrida_id' => $this->corridaId,
            'nome' => $row['nome'],
            'data_nascimento' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['data_nascimento'])->format('Y-m-d'),
        ]);
    }
}
