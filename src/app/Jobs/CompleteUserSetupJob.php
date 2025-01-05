<?php

namespace App\Jobs;

use App\Core\Application\User\Job\CompleteUserSetupJobHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CompleteUserSetupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 10;

    public function __construct(
        private readonly string $userId
    ) {}

    public function handle(CompleteUserSetupJobHandler $handler): void
    {
        $handler->execute($this->userId);
    }
}
