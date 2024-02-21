<?php

namespace App\Http\Controllers;

use App\Models\corridas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $dataView = [];
        $dataView['corrida'] = corridas::latest('created_at')->first();
        $dataView['corridas'] = corridas::orderBy('created_at','desc')->get();
        $dataFormatada = Carbon::createFromFormat('Y-m-d H:i:s', $dataView['corrida']->created_at )->format('Y-m-d');

        if($dataFormatada == date('Y-m-d'))
        {
            $dataView['live'] = true;
        }else{
            $dataView['live'] = false;
        }

        return view('layouts.layouts',
        [
            'viewData' => $dataView
        ]);
    }
}
