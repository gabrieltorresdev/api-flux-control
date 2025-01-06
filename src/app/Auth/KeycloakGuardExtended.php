<?php

namespace App\Auth;

use App\Core\Application\User\Action\CreatePendingUserFromKeycloakAction;
use App\Core\Domain\Enum\UserStatus;
use App\Jobs\CompleteUserSetupJob;
use KeycloakGuard\KeycloakGuard;
use KeycloakGuard\Exceptions\UserNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class KeycloakGuardExtended extends KeycloakGuard
{
    public function __construct($provider, $request)
    {
        parent::__construct($provider, $request);
    }

    public function validate(array $credentials = []): bool
    {
        try {
            return parent::validate($credentials);
        } catch (UserNotFoundException $e) {
            $username = $credentials[$this->config['user_provider_credential']] ?? null;
            if (!$username) {
                throw $e;
            }

            $lockKey = "user_initialization_{$username}";
            $lock = cache()->lock($lockKey, 30); // Aumentado para 30 segundos
            $maxAttempts = 5;
            $attempt = 0;

            try {
                while ($attempt < $maxAttempts) {
                    if ($lock->get()) {
                        $this->initializeUserEnvironmentFromToken($credentials);
                        return parent::validate($credentials);
                    }

                    $attempt++;
                    if ($attempt < $maxAttempts) {
                        // Exponential backoff com jitter
                        $sleepMs = min(1000 * pow(2, $attempt), 5000) + rand(100, 1000);
                        usleep($sleepMs * 1000);
                    }
                }

                throw new \RuntimeException('Failed to acquire lock after maximum attempts');
            } finally {
                if ($lock->owned()) {
                    $lock->release();
                }
            }
        }
    }

    public function user()
    {
        $user = parent::user();

        if (!$user) {
            return null;
        }

        if (request()->route()->uri() !== 'api/v1/users/status' && $user->status->value !== UserStatus::COMPLETED->value) {
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
        }

        return $user;
    }

    protected function initializeUserEnvironmentFromToken(array $credentials): void
    {
        $username = $credentials[$this->config['user_provider_credential']] ?? null;

        if (!$username || !$this->decodedToken) {
            throw new UserNotFoundException('Unable to create user: missing required data');
        }

        $user = app(CreatePendingUserFromKeycloakAction::class)->execute(
            name: $this->decodedToken->name ?? $username,
            email: $this->decodedToken->email ?? $username,
            username: $username,
            keycloakId: $this->decodedToken->sub
        );

        CompleteUserSetupJob::dispatch($user->id);
    }
}
