<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateMiddleware
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
       
        if($request->session()->has('user')){
            if($request->path() == 'access'){
                return redirect($request->session()->get('user')->type);
            }elseif(preg_match('/^'.$request->session()->get('user')->type.'/', $request->path()) == 0){
                return redirect($request->session()->get('user')->type);
            }
        }else{
            $page = array('admin', 'student', 'teacher');
            
            $page = array_where($page, function($key, $value){
                if(preg_match('/^'.$key.'/', \Request::path()) == 1) {return $key; }
            });
            
            if(count($page) > 0)
                return redirect('/');
        }

        return $next($request);
    }
}
