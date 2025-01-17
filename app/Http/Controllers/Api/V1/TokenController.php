<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Services\TokenService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Token\TokenResource;

class TokenController extends Controller
{
    private $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function __invoke(Request $request)
    {
        $token = $this->tokenService->getToken($request->bearerToken());

        return new TokenResource($token);
    }
}
