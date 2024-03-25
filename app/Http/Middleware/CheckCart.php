<?php

namespace App\Http\Middleware;

use Closure;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;

class CheckCart
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
        $cart = \Cart::getContent();
        if ($cart->isEmpty()) {
            return redirect()->route('shop')->with('error', 'Your cart is empty. Please add items to your cart before checking out.');
        }
        return $next($request);
    }
}
