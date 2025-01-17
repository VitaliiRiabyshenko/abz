<?php

namespace App\Http\Services;

use App\Models\Token;
use Illuminate\Support\Str;

class TokenService
{
    public function getToken($bearerToken)
    {
        $token = Token::whereNotNull('token')
            ->when($bearerToken, function ($q) use ($bearerToken) {
                return $q->where('token', $bearerToken);
            })
            ->whereRaw("TIMESTAMPDIFF(MINUTE, expired_at, UTC_TIMESTAMP()) < 40")
            ->where('used', 0)
            ->first();

        if (!$token) {
            do {
                $str = Str::random(64);
            } while (Token::where('token', $str)->exists());

            $token = Token::create([
                'token' => $str,
                'expired_at' => now()->addMinutes(40),
            ]);
        }

        return $token;
    }
}