<?php

namespace App\Jobs;

use App\Core\Application\User\Job\CompleteUserSetupJobHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

class CompleteUserSetupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $maxExceptions = 1;
    public int $backoff = 10;

    public function __construct(
        private readonly string $userId
    ) {}

    public function handle(CompleteUserSetupJobHandler $handler): void
    {
        $handler->execute($this->userId);
    }

    public function middleware(): array
    {
        return [
            new WithoutOverlapping($this->userId),
            new RateLimited('user-setup')
        ];
    }

    public function retryUntil(): \DateTime
    {
        return now()->addMinutes(5);
    }

    public function failed(\Throwable $exception): void
    {
        // Job falhou após todas as tentativas
        // O status já foi atualizado para FAILED no handler
        Log::error('Failed to complete user setup', [
            'userId' => $this->userId,
            'error' => $exception->getMessage()
        ]);
    }
}
