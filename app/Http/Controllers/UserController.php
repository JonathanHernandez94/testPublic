<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponseWrapper;
use App\Http\Requests\IdentifyRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Models\User;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(private readonly AuthServiceInterface $authService)
    {
    }

    public function getUserAuthData(LoginRequest $request): JsonResponse
    {
        $validatedLoginData = $request->validated();
        $user = User::where('email', $validatedLoginData['email'])->first();

        return  JsonResponseWrapper::SuccessResponse([
            'user' => $user,
            'token' => $this->authService->login($user)
        ]);
    }

    public function getUserByToken(IdentifyRequest $request): JsonResponse
    {
        $validatedIdentifyRequest = $request->validated();
        $userId = $this->authService->identify($validatedIdentifyRequest['token']);
        $user = User::findOrFail($userId);

        return  JsonResponseWrapper::SuccessResponse($user);
    }

    public function logout(LogoutRequest $request): JsonResponse
    {
        $validatedLogoutRequest = $request->validated();
        return JsonResponseWrapper::SuccessResponse($this->authService->logout());
    }
}
