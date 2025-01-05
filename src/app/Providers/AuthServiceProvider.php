<?php

namespace App\Providers;

use App\Auth\KeycloakGuardExtended;
use App\Core\Application\User\Action\CreateUserFromKeycloakAction;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Auth::extend('keycloak', function ($app, $name, array $config) {
            $createUserAction = $app->make(CreateUserFromKeycloakAction::class);

            return new KeycloakGuardExtended(
                Auth::createUserProvider($config['provider']),
                $app['request'],
                $createUserAction
            );
        });
    }
}
