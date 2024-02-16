<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\corridas;
use Illuminate\Http\Request;

class getRacingController extends Controller
{
    public function storeOrUpdateRacing(Request $request){

        $event = corridas::where('created_at','like','%'.date('Y-m-d').'%')->first();

        if(!$event){
            $dados = json_decode(json_encode($request->all()));
            $evento = new corridas();
            $evento->name = $dados->eventName;
            $evento->dados = json_encode($dados->rows);
            $evento->save();
        }else{
            $dados = json_decode(json_encode($request->all()));
            corridas::where('id',$event->id)->update(['dados' => json_encode($dados->rows)]);
        }

    }
}
