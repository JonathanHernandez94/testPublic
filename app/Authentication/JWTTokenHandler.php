<?php

namespace App\Authentication;

use App\Authentication\Contracts\TokenHandlerInterface;
use App\Models\User;

class JWTTokenHandler implements TokenHandlerInterface
{

    public function generateToken(User $username): string
    {
        // TODO: Implement generateToken() method.
    }

    public function decodeToken(string $token): array
    {
        // TODO: Implement decodeToken() method.
    }
}
