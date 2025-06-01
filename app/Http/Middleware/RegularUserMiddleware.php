<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegularUserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->account_type === 'regular') {
            return $next($request);
        }
        return redirect('/');  // Redirect to home page or any other page
    }
}
