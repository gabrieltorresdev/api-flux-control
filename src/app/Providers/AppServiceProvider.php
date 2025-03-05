<?php

namespace App\Providers;

use App\Auth\KeycloakGuardExtended;
use App\Core\Application\Dashboard\Action\GetInsightsAction;
use App\Core\Domain\Service\CategorySpendingAnalyzer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register GetInsightsAction with CategorySpendingAnalyzer
        $this->app->bind(GetInsightsAction::class, function ($app) {
            return new GetInsightsAction([
                $app->make(CategorySpendingAnalyzer::class)
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::extend('keycloak', function ($app, $name, array $config) {
            return new KeycloakGuardExtended(
                Auth::createUserProvider($config['provider']),
                $app['request']
            );
        });
    }
}
