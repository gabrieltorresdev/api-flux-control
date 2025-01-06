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
            $lock = cache()->lock($lockKey, 10); // 10 seconds timeout

            try {
                if ($lock->get()) {
                    $this->initializeUserEnvironmentFromToken($credentials);
                    return parent::validate($credentials);
                }

                // Wait for initialization to complete
                $maxAttempts = 10;
                $attempt = 0;

                while ($attempt < $maxAttempts) {
                    if (parent::validate($credentials)) {
                        return true;
                    }
                    $attempt++;
                    usleep(100000); // 100ms delay between attempts
                }

                return parent::validate($credentials);
            } finally {
                optional($lock)->release();
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
