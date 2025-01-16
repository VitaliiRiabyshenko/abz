<?php

namespace App\Http\Controllers\Api\V1;

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

    public function __invoke()
    {
        $token = $this->tokenService->getToken();

        return new TokenResource($token);
    }
}
