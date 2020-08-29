<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;

class Currency
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
        $raw_currency = $request->cookie('currency');

        if (in_array($raw_currency, Config::get('app.currencies'))) {
            $currency = $raw_currency;
        }
        else $currency = env('CURRENCY');
        $request->session()->put("currency",$currency);

        return $next($request);
    }
}
