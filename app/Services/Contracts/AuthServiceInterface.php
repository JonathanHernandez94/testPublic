<?php

namespace App\Services\Contracts;

use App\DTO\Authentication\Contracts\AuthenticationDTOInterface;

interface AuthServiceInterface
{
    public function login(AuthenticationDTOInterface $loginPayloadDTO): string;
    public function logout(): bool;
}
