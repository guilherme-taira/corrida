<?php

use App\Http\Controllers\api\getRacingController;
use App\Http\Controllers\corridas\corridaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('v1')->group(function () {

    Route::get('/eventos-online', [corridaController::class, 'eventosOnline']);
    Route::post('/importar-evento', [corridaController::class, 'importarEvento']);

    Route::get('sendData',[getRacingController::class,'storeOrUpdateRacing']);
    Route::get('/corridas/{id}', [corridaController::class, 'show']);
    Route::post('/cadastrar', [corridaController::class, 'storeHandler']);

});
