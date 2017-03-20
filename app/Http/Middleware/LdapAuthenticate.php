<?php

namespace App\Http\Middleware;

use Closure, Session;

class LdapAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Session::has('ldap')) {
             return $next($request);
        } 
        else{
            return redirect('/');
        }
        
      }
      
}
