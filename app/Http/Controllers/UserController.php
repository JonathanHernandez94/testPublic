<?php

namespace App\Http\Controllers;

use App\DTO\Authentication\LoginPayloadDTO;
use App\Helpers\JsonResponseWrapperHelper;
use App\Http\Requests\IdentifyRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Models\User;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(private readonly AuthServiceInterface $authService)
    {
    }

    public function getUserAuthData(LoginRequest $request): JsonResponse
    {
        $validatedLoginData = $request->validated();
        $user = User::where('email', $validatedLoginData['email'])
            ->with(['organizations' => function($query) {
                $query->limit(1);
            }])
            ->first();

        return  JsonResponseWrapperHelper::SuccessResponse([
            'user' => $user,
            'token' => $this->authService->login(LoginPayloadDTO::fromUser($user))
        ]);
    }

    public function getUserByToken(IdentifyRequest $request): JsonResponse
    {
        return JsonResponseWrapperHelper::SuccessResponse(Auth::guard('api')->user());
    }

    public function logout(LogoutRequest $request): JsonResponse
    {
        return JsonResponseWrapperHelper::SuccessResponse($this->authService->logout());
    }
}
