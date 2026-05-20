<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // nếu là admin
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }
        // không phải admin
        return redirect('/dashboard');
    }
}

