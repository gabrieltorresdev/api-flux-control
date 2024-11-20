<?php

namespace App\Providers;

use App\Persistence\Eloquent\Repository\UserRepository;
use App\Core\Domain\Repository\IUserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(IUserRepository::class, UserRepository::class);
    }
}
