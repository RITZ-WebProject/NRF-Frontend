<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ClearCartWhenIdle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
    	if (auth()->check() && session()->has('custoer_uniquekey')) {
            $last_activity = session('last_activity');
            $current_time = time();

            if (($current_time - $last_activity) > (3 * 60)) {
                $cart = new Cart();
                $cart->clear();

                session()->flush(); // or you can use session()->invalidate()
            }
        }

        session(['last_activity' => time()]);
   
        return $next($request);
    }
}
