<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CatalogViewMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('view-products')) {
            $request->session()->put('view-products', $request->get('view-products'));
        }

        return $next($request);
    }
}
