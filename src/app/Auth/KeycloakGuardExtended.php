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
            $this->initializeUserEnvironmentFromToken($credentials);
            return parent::validate($credentials);
        }
    }

    public function user()
    {
        $user = parent::user();

        if (!$user) {
            return null;
        }

        match ($user->status) {
            UserStatus::PENDING => $this->respondWithPendingStatus(),
            UserStatus::FAILED => $this->respondWithFailedStatus(),
        };

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

    private function respondWithPendingStatus(): never
    {
        abort(Response::HTTP_ACCEPTED, 'Seu ambiente está sendo preparado, aguarde');
    }

    private function respondWithFailedStatus(): never
    {
        abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Houve um erro na criação do seu ambiente');
    }
}
