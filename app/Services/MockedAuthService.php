<?php

namespace App\Services;

use App\Authentication\Contracts\TokenGeneratorInterface;
use App\DTO\Authentication\Contracts\AuthenticationDTOInterface;
use App\Models\User;
use App\Services\Contracts\AuthServiceInterface;

readonly class MockedAuthService implements AuthServiceInterface
{
    public function __construct(
        private TokenGeneratorInterface $tokenGenerator,
    )
    {
    }

    public function login(AuthenticationDTOInterface $loginPayloadDTO): string
    {
        return $this->tokenGenerator->generate($loginPayloadDTO);
    }

    /**
     * Doing nothing, this is handled in the fronted
     */
    public function logout(): bool
    {
        return true;
    }

}
