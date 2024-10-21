<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $data): Response
    {
        echo $data;

        if($data == "123")
        {

            echo "Hello World";
        }


        if(true)
        {
            return $next($request);
        }
        return Response('Chegamos Auth');
    }
}
