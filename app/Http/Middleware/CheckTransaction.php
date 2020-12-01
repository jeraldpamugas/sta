<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTransaction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(session()->has('code')){

            $usertype = session()->get('usertype');
    
            if($usertype == 'staff'){
                return $next($request);
            }
            return redirect('transactions');
        }
        
        return redirect('/');
    }
}
