<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class TermsAgree
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next( $request );
        if($user = Auth::user()){
            foreach ($user->programs as $pr){
                if(!in_array($pr->id,$user->agreements->pluck('id')->toArray())){
                    Flash::overlay('Terminos del programa: <strong>' . $pr->name . '</strong>
                    <br>
                    <br>
                  
                    ' . nl2br($pr->terms)
                        . '
                                            <div class="form-group text-right">
                        <h4>¿Aceptas estos términos y condiciones?</h4>
                        <a href="/user/agree/'. $pr->id .'" class="btn btn-success">Acepto</a>
                        <a href="logout" class="btn btn-default">No Acepto</a>
                    </div>
',
                        'Para continuar debes aceptar los términos y condiciones de cada programa en el que estas participando');
                }
            }
        }
        return $response;
    }
}
