<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Token;
use Illuminate\Http\Request;

class APITokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->bearerToken()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token. Try to get a new one by the method GET api/v1/token.'
            ], 401);
        } else {
            $AuthToken = $request->bearerToken();

            $token = Token::where('token', $AuthToken)
                ->whereRaw("TIMESTAMPDIFF(MINUTE, expired_at, UTC_TIMESTAMP()) > 40")
                ->where('used', 0)
                ->first();

            if ($token) {
                return response()->json([
                    'success' => false,
                    'message' => 'The token expired.'
                ], 401);
            } else {
                $tokenExists = Token::where('token', $AuthToken)->where('used', 0)->first();
                if (!$tokenExists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This action is unauthorized'
                    ], 403);
                }
            }
        };
        return $next($request);
    }
}
