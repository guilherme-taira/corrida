<?php

namespace App\Http\Controllers\corridas;

use App\Http\Controllers\Controller;
use App\Models\corridas;
use App\Models\DadosDoAtleta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
set_time_limit(0); // tempo em segundos

class corridaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index() {
   $corridas = corridas::orderBy('created_at', 'desc')->get()->map(function ($corrida) {
    return [
        'id' => $corrida->id,
        'name' => $corrida->name,
        'created_at' => $corrida->created_at,
        'local' => $corrida->local ?? '---',
        'imagem' => $corrida->imagem ?? null,
        'user_id' => $corrida->user_id,
        'cidade' => $corrida->cidade ?? '---'
        ];
    });

    if (request()->ajax()) {
        return response()->json($corridas);
    }

    return view('corridas.index', [
        'viewData' => [
            'title' => 'Lista de Corridas',
        ]
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataView = [];
        $dataView['corridas'] = corridas::paginate(10);

        return view('corridas.create',[
            'viewData' => $dataView
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dados' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dados = json_decode($request->dados);
        $evento = new corridas();
        $evento->name = $dados->eventName;
        $evento->dados = json_encode($dados->rows);
        $evento->save();

        return redirect()->route('corridas.index');
    }

    /**
     * Display the specified resource.
     */
     public function show($id)
    {
        $corrida = corridas::findOrFail($id);

        return response()->json([
            'id' => $corrida->id,
            'name' => $corrida->name,
            'dados' => json_decode($corrida->dados, true), // já envia como array
            'banner' => $corrida->banner,
            'certificado' => $corrida->certificado,
            'cidade' => $corrida->cidade,
            'local' => $corrida->local
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, string $id)
{
    $corrida = corridas::findOrFail($id);

    // Atualiza os campos principais
    $corrida->name = $request->name;
    $corrida->local = $request->local;
    $corrida->cidade = $request->cidade;
    $corrida->exibir_tempo_liquido = $request->exibir_tempo_liquido;
    $corrida->exibir_gap = $request->exibir_gap;
    $corrida->exibir_tempo_bruto = $request->exibir_tempo_bruto;

    // Uploads (opcionais)
    if ($request->hasFile('imagem')) {
        $corrida->imagem = $request->file('imagem')->store('corridas/imagens', 'public');
    }

    if ($request->hasFile('banner')) {
        $corrida->banner = $request->file('banner')->store('corridas/banners', 'public');
    }

    if ($request->hasFile('certificado')) {
        $corrida->certificado = $request->file('certificado')->store('corridas/certificados', 'public');
    }

    $corrida->save();

    // Importa Excel de atletas (opcional)
    if ($request->hasFile('arquivo_excel')) {
        try {
            $spreadsheet = IOFactory::load($request->file('arquivo_excel')->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            // Remove cabeçalho
            array_shift($rows);


            // Apaga atletas antigos
            DadosDoAtleta::where('corrida_id', $corrida->id)->delete();

           foreach ($rows as $index => $row) {
            try {
                // Pula linha vazia ou incompleta
                if (count(array_filter($row)) < 5) {
                    Log::warning("Linha " . ($index + 2) . " ignorada: dados insuficientes.");
                    continue;
                }

                // Extrai os dados com base nos índices esperados
                $nome = trim($row[0] ?? '');
                $distancia = trim($row[2] ?? '');
                $sexo = strtoupper(trim($row[4] ?? ''));
                $dataNascimentoBruta = $row[3] ?? '';
                $equipe = trim($row[5] ?? '');

                // Validação do sexo
                if (!in_array($sexo, ['M', 'F'])) {
                    Log::warning("Sexo inválido na linha " . ($index + 2) . ": $sexo");
                    continue;
                }

                // Validação da data de nascimento
                try {
                    $dataNascimento = \Carbon\Carbon::parse($dataNascimentoBruta)->format('Y-m-d');
                } catch (\Exception $e) {
                    Log::warning("Data inválida na linha " . ($index + 2) . ": {$dataNascimentoBruta}");
                    continue;
                }

                // Criação do registro
                DadosDoAtleta::create([
                    'corrida_id' => $corrida->id,
                    'nome' => $nome,
                    'distancia' => $distancia,
                    'sexo' => $sexo,
                    'data_nascimento' => $dataNascimento,
                    'equipe' => $equipe,
                ]);

            } catch (\Exception $e) {
                Log::warning("Erro ao importar linha " . ($index + 2) . ": " . $e->getMessage());
                continue;
            }
}


        } catch (\Exception $e) {
            Log::error("Erro ao processar arquivo Excel: " . $e->getMessage());
            return back()->with('error', 'Erro ao processar o arquivo Excel.');
        }
    }

    return redirect()->route('corridas.index')->with('msg', 'Evento atualizado com sucesso!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $corrida = corridas::where('id',$id)->delete();

        if($corrida == 1){
            return redirect()->route('corridas.index')->with('msg',"Evento Apagado com Sucesso!");
        }
    }

public function apiEventos()
{
    try {
        $eventos = corridas::select('id', 'name', 'created_at','imagem','local','cidade')->get();
        return response()->json($eventos);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
