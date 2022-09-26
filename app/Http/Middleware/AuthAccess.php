<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // dd($role." | ".auth()->user()->role());
        if (auth()->user()->role() == $role) {
            
            return $next($request);
        }

        return response()->json(['Tidak memiliki akses 404']);
    }
}
