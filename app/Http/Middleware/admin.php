<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()) {
            return $next($request);
        } else {
            if (Auth::user()) {
                return redirect()->route('login')->with('mgs_login', "Usuário:".Auth::user()->name." Não tem Permissão para Navegar nesta Página");
            } else {
                return redirect()->route('login')->with('mgs_login', 'Para Acessar essa tela precisa estar conectado!');
            }
        }
    }
}
