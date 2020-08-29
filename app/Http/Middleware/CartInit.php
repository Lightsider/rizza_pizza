<?php

namespace App\Http\Middleware;

use App\Services\Cart;
use Closure;

class CartInit
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
        $cart = new Cart($request);
        $cart->setCurrency($request->session()->get('currency') ?? env('CURRENCY'));
        view()->share('cart', $cart);
        return $next($request);
    }
}
