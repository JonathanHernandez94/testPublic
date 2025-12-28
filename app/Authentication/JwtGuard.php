<?php

namespace App\Authentication;

use App\Models\Organization;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class JwtGuard implements Guard
{
    public function __construct(
        protected UserProvider $provider,
        protected Request $request,
        protected ?Authenticatable $user = null, // Added to improve testability
        protected ?int $organizationId = null // Added to improve testability
    )
    {
    }

    public function check(): bool
    {
        return $this->user() !== null;
    }

    public function guest(): bool
    {
        return !$this->check();
    }

    public function user(): ?Authenticatable
    {
        if($this->hasUser()) {
            return $this->user;
        }

        try {
            $token = $this->getTokenFromRequest();
            $payload = (array) JWT::decode($token, new Key(config('jwt.secret'), 'HS256'));
            $user = $this->provider->retrieveById($payload['sub'] ?? null);
            $this->setUser($user);
            $this->organizationId = $payload['orgId'] ?? null;
        } catch (\Exception $e) {
            $this->user = null;
            $this->organizationId = null;
        }

        return $this->user;
    }

    public function id(): mixed
    {
        return $this->user()?->getAuthIdentifier();
    }

    public function validate(array $credentials = []): void
    {
        // Don't need this one at the moment and isn't that fast to implement, so just skipping this
    }

    public function hasUser(): bool
    {
        return !is_null($this->user);
    }

    public function setUser(Authenticatable $user): void
    {
        $this->user = $user;
    }

    public function getOrganizationId(): ?int
    {
        return $this->organizationId;
    }

    /**
     * Assuming we are sending the JWT in the request Header Authorization
     */
    protected function getTokenFromRequest(): ?string
    {
        $header = $this->request->header('Authorization', '');
        if (str_starts_with($header, 'Bearer ')) {
            return substr($header, 7);
        }
        return null;
    }
}
