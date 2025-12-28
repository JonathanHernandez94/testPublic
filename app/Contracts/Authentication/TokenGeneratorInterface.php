<?php

namespace App\Contracts\Authentication;

interface TokenGeneratorInterface
{
    public function generate(AuthenticationDTOInterface $loginPayloadDTO): string;
}
