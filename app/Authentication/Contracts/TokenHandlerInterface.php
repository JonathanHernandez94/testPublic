<?php

namespace App\Authentication\Contracts;

use App\Models\User;

interface TokenHandlerInterface
{
    public function generateToken(User $username): string;
    public function decodeToken(string $token): array;
}
