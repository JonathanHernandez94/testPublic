<?php

namespace App\Providers;

use App\Authentication\Contracts\TokenGeneratorInterface;
use App\Authentication\JwtGuard;
use App\Authentication\JwtTokenGenerator;
use App\DTO\Authentication\Contracts\AuthenticationDTOInterface;
use App\DTO\Authentication\LoginPayloadDTO;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\MockedAuthService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, MockedAuthService::class);
        $this->app->bind(TokenGeneratorInterface::class, JwtTokenGenerator::class);
        $this->app->bind(AuthenticationDTOInterface::class, LoginPayloadDTO::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::extend('jwt', function (Application $app, string $name, array $config) {
            return new JwtGuard(Auth::createUserProvider($config['provider']), $app['request']);
        });
    }
}
