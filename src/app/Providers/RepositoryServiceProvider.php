<?php

namespace App\Providers;

use App\Core\Domain\Repository\ICategoryRepository;
use App\Core\Domain\Repository\ITransactionRepository;
use App\Persistence\Eloquent\Repository\CategoryRepository;
use App\Persistence\Eloquent\Repository\TransactionRepository;
use App\Persistence\Eloquent\Repository\UserRepository;
use App\Core\Domain\Repository\IUserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(IUserRepository::class, UserRepository::class);
        $this->app->singleton(ICategoryRepository::class, CategoryRepository::class);
        $this->app->singleton(ITransactionRepository::class, TransactionRepository::class);
    }
}
