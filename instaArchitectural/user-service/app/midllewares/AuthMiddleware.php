<?php
namespace App\Http\Middleware;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {

        $token = $request->bearerToken();
        $response = Http::withToken($token)->get('http://auth-service/api/me');

        if ($response->successful()) {
            $request->merge(['user' => $response->json()]);
            return $next($request);
        }
        return response()->json(['message' => 'Unauthorized'], 401);

    }
}
