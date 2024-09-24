<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use App\Helper\Helper;

class PublicTokenMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->route('client_code')) {
            Session::put(['client_code' => $request->client_code, 'username' => 'admin@uom']);
        } else {
            echo "Client code not found!";
            exit();
        }
        return $next($request);
    }
}
