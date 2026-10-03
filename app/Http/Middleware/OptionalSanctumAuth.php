<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OptionalSanctumAuth
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->bearerToken()) {
            $token = \Laravel\Sanctum\PersonalAccessToken::findToken($request->bearerToken());
            if ($token) {
                $request->setUserResolver(fn() => $token->tokenable);
            }
        }

        return $next($request);
    }
}