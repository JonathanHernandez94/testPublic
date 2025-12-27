<?php

namespace App\Providers;

use App\Authentication\Contracts\TokenHandlerInterface;
use App\Authentication\Contracts\TokenValidatorInterface;
use App\Authentication\JWTTokenHandler;
use App\Authentication\JWTTokenValidator;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\MockedAuthService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, MockedAuthService::class);
        $this->app->bind(TokenHandlerInterface::class, JWTTokenHandler::class);
        $this->app->bind(TokenValidatorInterface::class, JWTTokenValidator::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
