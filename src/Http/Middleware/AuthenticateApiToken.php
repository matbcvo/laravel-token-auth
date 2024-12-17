<?php

namespace Matbcvo\LaravelTokenAuth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Matbcvo\LaravelTokenAuth\Models\ApiToken;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (is_null($token) || ! $this->isValidToken($token)) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }

    private function isValidToken(string $token): bool
    {
        $apiToken = ApiToken::where('token', $token)->first();

        return $apiToken && ! $apiToken->isExpired();
    }
}
