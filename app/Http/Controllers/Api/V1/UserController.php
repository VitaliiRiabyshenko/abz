<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\FilterRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(FilterRequest $request)
    {
        $data = $request->validated();

        $users = User::pagination($data['page'] ?? null, $data['count'] ?? null);

        return new UserCollection($users);
    }

    public function store(StoreRequest $request)
    {
        return $this->userService->setStore($request->validated());
    }

    public function show($id)
    {
        return new UserResource(User::findOrFail($id));
    }
}
