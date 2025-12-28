<?php

namespace App\Authentication\Contracts;

use App\DTO\Authentication\Contracts\AuthenticationDTOInterface;

interface TokenGeneratorInterface
{
    public function generate(AuthenticationDTOInterface $loginPayloadDTO): string;
}
