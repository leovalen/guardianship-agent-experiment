<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class McpHeadersMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        
        $request->headers->set('Accept', 'text/event-stream');

        return $next($request);
    }
}