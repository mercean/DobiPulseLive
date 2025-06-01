<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->account_type === 'admin') {
            return $next($request);
        }

        abort(403, 'Unauthorized. Admin access only.');
    }
}

