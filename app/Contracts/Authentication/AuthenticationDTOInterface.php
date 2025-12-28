<?php

namespace App\Contracts\Authentication;

use App\Models\User;

interface AuthenticationDTOInterface
{
    public static function fromUser(User $user): self;

    public function toArray(): array;
}
