<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class ClientCodeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $arr = $request->all();
        $string = $request->input('data', '');
    
        if (empty($string)) {
            return response()->json(['error' => 'Something went wrong'], 400);
        }
    
        $decodedString = base64_decode($string);
    
        if ($decodedString === false) {
            return response()->json(['error' => 'Invalid base64 encoding'], 400);
        }
    
        $data = json_decode($decodedString, true);
    
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid JSON format'], 400);
        }
    
        $client = $data['client_code'] ?? null;
        $username = $data['user_name'] ?? null;
    
        if (!$client || !$username) {
            return response()->json(['error' => 'Missing client_code or username in the token data'], 400);
        }
    
        Session::put(['client_code' => $client, 'username' => $username]);
    
        $response = $next($request);
        return $response;
    }
}
