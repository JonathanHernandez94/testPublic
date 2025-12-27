<?php

namespace App\Authentication;

use App\Authentication\Contracts\TokenValidatorInterface;

class JWTTokenValidator implements TokenValidatorInterface
{

    public function isTokenValid(string $token): bool
    {
        // TODO: Implement isTokenValid() method.
    }
}
