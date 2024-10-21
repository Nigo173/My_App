<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\LogModel;


class LogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $ip = $request->server->get('REMOTE_ADDR');
        $mac= strtok(exec('getmac'), ' ');
        $url = $request->getRequestUri();
        
        LogModel::create(['log' => 'MAC: '.$mac.' FROM: '.$url]);
        // $response = $next($request);
        // $response->setStatusCode(201, '0 sssssssssssss');
        return $next($request);
    }
}
