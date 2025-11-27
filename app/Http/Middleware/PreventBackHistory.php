<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventBackHistory
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Check if response has header method (not StreamedResponse)
        if (method_exists($response, 'header')) {
            return $response->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
                            ->header('Pragma','no-cache')
                            ->header('Expires','Sun, 02 Jan 1990 00:00:00 GMT');
        }

        return $response;
    }
}