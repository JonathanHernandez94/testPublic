<?php

namespace App\Authentication;

use App\Contracts\Authentication\AuthenticationDTOInterface;
use App\Contracts\Authentication\TokenGeneratorInterface;
use Firebase\JWT\JWT;

class JwtTokenGenerator implements TokenGeneratorInterface
{
    public function generate(AuthenticationDTOInterface $loginPayloadDTO): string
    {
        return JWT::encode($loginPayloadDTO->toArray(), config('jwt.secret'), 'HS256' );
    }
}
