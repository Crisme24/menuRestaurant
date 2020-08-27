<?php

namespace App\Http\Middleware;

use Closure;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        $role = $request->user()->role;//Aqui guardo el rol del usuario que esta ejecutando la peticion, tb lo puedo usar de esta manera Auth::user()->role;
        $allowedRoles = explode('|', $roles);//Aqui viene roles permitidos en string y aqui los convertimos en array
        //dd($allowedRoles, $role, in_array($role, $allowedRoles));
        if(!in_array($role, $allowedRoles)){//Si el rol NO esta autorizado
            return response(['message'=> 'You are not allowed to perform this action'], 403);
        }
        return $next($request);
    }
}
