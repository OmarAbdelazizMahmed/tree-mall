<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthStore
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
        if (!auth()->check() || auth()->user()->is_store_admin) {
            return redirect()->route('store.login');
        }
        return $next($request);
    }
}
