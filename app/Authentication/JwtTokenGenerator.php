<?php

namespace App\Authentication;

use App\Authentication\Contracts\TokenGeneratorInterface;
use App\DTO\Authentication\Contracts\AuthenticationDTOInterface;
use Firebase\JWT\JWT;

class JwtTokenGenerator implements TokenGeneratorInterface
{
    public function generate(AuthenticationDTOInterface $loginPayloadDTO): string
    {
        return JWT::encode($loginPayloadDTO->toArray(), config('jwt.secret'), 'HS256' );
    }
}
