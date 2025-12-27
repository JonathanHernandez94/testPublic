<?php

namespace App\Authentication\Contracts;

interface TokenValidatorInterface
{
    public function isTokenValid(string $token): bool;
}
