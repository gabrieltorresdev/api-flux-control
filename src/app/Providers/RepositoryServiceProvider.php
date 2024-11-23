<?php

namespace App\Providers;

use App\Core\Domain\Repository\ITransactionCategoryRepository;
use App\Core\Domain\Repository\ITransactionRepository;
use App\Persistence\Eloquent\Repository\TransactionCategoryRepository;
use App\Persistence\Eloquent\Repository\TransactionRepository;
use App\Persistence\Eloquent\Repository\UserRepository;
use App\Core\Domain\Repository\IUserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(IUserRepository::class, UserRepository::class);
        $this->app->singleton(ITransactionCategoryRepository::class,  TransactionCategoryRepository::class);
        $this->app->singleton(ITransactionRepository::class,  TransactionRepository::class);
    }
}
