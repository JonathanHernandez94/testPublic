<?php

namespace App\DTO\Authentication;

use App\Contracts\Authentication\AuthenticationDTOInterface;
use App\Models\User;

readonly class LoginPayloadDTO implements AuthenticationDTOInterface
{
    public function __construct(
        public int $sub,
        public string $email,
        public string $role,
        public ?int $orgId = null,
        public ?int $exp = null
    )
    {
    }

    public static function fromUser(User $user): self
    {
        return new self(
            sub: $user->id,
            email: $user->email,

             /**
              * Using the organizations()->first because:
              * Assuming that initially, there is a user already logged into an organization (in the future a 2-step authentication,
              * first step returning all user organizations,
              * second step creating the token for the selected organization) and we can access it from the Guard('api')
              * not now since we are not sending org_id in the login request payload
              */
            role: $user->organizations?->first()->pivot->role?->value ?? null,
            orgId: $user->organizations?->first()->id ?? null,
            exp: time() + config('jwt.exp'),
        );
    }

    public function toArray(): array
    {
        return [
            'sub'   => $this->sub,
            'email' => $this->email,
            'role'  => $this->role,
            'orgId' => $this->orgId,
            'exp'   => $this->exp
        ];
    }
}
