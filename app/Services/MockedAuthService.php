<?php

namespace App\Services;

use App\Authentication\Contracts\TokenHandlerInterface;
use App\Models\User;
use App\Services\Contracts\AuthServiceInterface;

class MockedAuthService implements AuthServiceInterface
{
    public function __construct(private TokenHandlerInterface $tokenHandler)
    {
    }

    public function login(User $user): string
    {
        return $this->tokenHandler->generateToken($user);
    }

    /**
     * Doing nothing, this is handled in the fronted
     */
    public function logout(): bool
    {
        return true;
    }

    public function identify(string $token): int
    {
        return $this->tokenHandler->decodeToken($token)['id'];
    }
}
