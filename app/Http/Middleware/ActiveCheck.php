<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActiveCheck
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
        if(session()->get('email')){
            date_default_timezone_set('Asia/Rangoon');
            DB::table('customers')->where('email', session()->get('email'))->orWhere('phone_primary', session()->get('email'))->update(['active_time' => now()]);

            return $next($request);
        }
        return $next($request);
    }
}
