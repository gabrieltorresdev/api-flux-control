<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use KeycloakGuard\KeycloakGuard;

class KeycloakServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/keycloak.php', 'keycloak');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/keycloak.php' => config_path('keycloak.php'),
        ], 'keycloak');

        Auth::extend('keycloak', function ($app, $name, array $config) {
            return new KeycloakGuard(
                Auth::createUserProvider($config['provider'] ?? null),
                $app['request'],
                config('keycloak')
            );
        });
    }
}
