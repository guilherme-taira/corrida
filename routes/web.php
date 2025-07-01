<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\corridaAuth;
use App\Http\Controllers\corridas\corridaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [corridaController::class,'index'])->name('index');
Route::post('/corridas/{corrida}/upload-atletas', [CorridaController::class, 'uploadAtletas'])->name('corridas.uploadAtletas');

Route::resource('resultados', 'App\Http\Controllers\corridas\corridaController')->names('corridas')->parameters(['resultados' => 'corrida']);
Route::get('/api/eventos', [corridaController::class, 'apiEventos']);
Route::post('/corridas/{id}', [corridaController::class, 'update']); // para aceitar PUT via _method

Route::middleware('admin')->group(function () {
    Route::get('edit/{id}',[corridaAuth::class,'edit'])->name('editar');
    Route::get('logoutOwn',[corridaAuth::class,'logout'])->name('sair');
});
;

Auth::routes();

// ⬇️ Esse precisa ficar por último para funcionar com Vue Router
Route::get('/{any}', function () {
    return view('app'); // sua SPA Vue
})->where('any', '^(?!api).*$'); // ignora rotas que começam com /api
