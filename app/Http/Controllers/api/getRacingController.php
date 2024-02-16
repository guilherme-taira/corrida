<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\corridas;
use Illuminate\Http\Request;

class getRacingController extends Controller
{
    public function storeOrUpdateRacing(Request $request){

        $event = corridas::where('created_at','like','%'.date('Y-m-d').'%')->first();

        $endpoint = "http://localhost:5050/results";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Accept: application/json']);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($httpcode == 200){
            if(!$event){
                $dados = json_decode($response);
                $evento = new corridas();
                $evento->name = $dados->eventName;
                $evento->dados = json_encode($dados->rows);
                $evento->save();
            }else{
                $dados = json_decode($response);
                corridas::where('id',$event->id)->update(['dados' => json_encode($dados->rows)]);
            }
        }


    }
}
