<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\corridas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class corridaAuth extends Controller
{
    public function edit(string $id)
    {
        $dataView = [];
        $dataView['corridas'] = corridas::where('id',$id)->first();
        $dataView['title'] = $dataView['corridas']->name;

        return view('corridas.edit',[
            'viewData' => $dataView
        ]);
    }


    public function logout(){

        Auth::logout();

        $dataView = [];
        $dataView['corridas'] = corridas::orderBy('created_at','desc')->get();
        $dataView['title'] = "Resultados";

        return view('corridas.index',[
            'viewData' => $dataView
        ]);
    }
}
