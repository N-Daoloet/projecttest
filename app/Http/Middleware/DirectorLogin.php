<?php

namespace App\Http\Middleware;

use Closure;
use Session;


class DirectorLogin
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
        if (!empty(Session::get('type')) && Session::get('type') == 'director' ) {
            return $next($request);
        }else{
            return redirect('/');
        }
    }
}
