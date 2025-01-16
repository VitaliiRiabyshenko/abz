<?php

namespace App\Http\Services;

use App\Models\Token;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class TokenService
{
    public function getToken()
    {
        $client_session = Cookie::get('laravel_session');

        $token = Token::whereNotNull('session')
            ->when($client_session, function ($q) use ($client_session) {
                return $q->where('session', $client_session);
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
                'session' => $client_session,
                'expired_at' => now()->addMinutes(40),
            ]);
        }

        return $token;
    }
}