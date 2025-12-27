<?php

namespace App\Services\Contracts;

use App\Models\User;

interface AuthServiceInterface
{
    public function login(User $user): string;
    public function logout(): bool;
    public function identify(string $token): int;
}
