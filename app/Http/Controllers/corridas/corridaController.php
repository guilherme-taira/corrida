<?php

namespace App\Http\Controllers\corridas;

use App\Http\Controllers\Controller;
use App\Models\corridas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class corridaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataView = [];
        $dataView['corridas'] = corridas::orderBy('created_at','desc')->get();
        $dataView['title'] = "Resultados";

        return view('corridas.index',[
            'viewData' => $dataView
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
    public function show(string $id)
    {
        $dataView = [];
        $dataView['corridas'] = corridas::where('id',$id)->first();
        $dataView['title'] = $dataView['corridas']->name;

        return view('corridas.show',[
            'viewData' => $dataView
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
        $corrida = corridas::where('id',$id)->update(['name' => $request->name]);

        if($corrida == 1){
            return redirect()->route('corridas.index')->with('msg',"Evento Alterado com Sucesso!");
        }
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
}
