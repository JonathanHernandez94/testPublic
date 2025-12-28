<?php

namespace App\Services;

use App\Contracts\Authentication\AuthenticationDTOInterface;
use App\Contracts\Authentication\TokenGeneratorInterface;
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
