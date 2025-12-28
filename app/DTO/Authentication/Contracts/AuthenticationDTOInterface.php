<?php

namespace App\DTO\Authentication\Contracts;

use App\Models\Organization;
use App\Models\User;

interface AuthenticationDTOInterface
{
    public static function fromUser(User $user): self;

    public function toArray(): array;
}
