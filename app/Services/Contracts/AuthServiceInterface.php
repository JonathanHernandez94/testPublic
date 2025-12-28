<?php

namespace App\Services\Contracts;

use App\Contracts\Authentication\AuthenticationDTOInterface;

interface AuthServiceInterface
{
    public function login(AuthenticationDTOInterface $loginPayloadDTO): string;
    public function logout(): bool;
}
