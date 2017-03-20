<?php

namespace App\Http\Middleware;

use Closure, Session;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $userAccess = Session::get('userAccess');
     //  dd($role,$userAccess);

       if($userAccess === 'superadmin' || $userAccess === 'admin')
          return $next($request);

        if($role === $userAccess){
            return $next($request);
        }
        else{
         //   dd($request);
            return redirect()->route('503');
        }

       
    }
}
