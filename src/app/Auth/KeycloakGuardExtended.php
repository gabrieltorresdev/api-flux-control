<?php

namespace App\Auth;

use App\Core\Application\User\Action\CreateUserFromKeycloakAction;
use KeycloakGuard\KeycloakGuard;
use KeycloakGuard\Exceptions\UserNotFoundException;

class KeycloakGuardExtended extends KeycloakGuard
{
    public function __construct($provider, $request, private CreateUserFromKeycloakAction $createUserAction)
    {
        parent::__construct($provider, $request);
        $this->createUserAction = $createUserAction;
    }

    public function validate(array $credentials = [])
    {
        try {
            return parent::validate($credentials);
        } catch (UserNotFoundException $e) {
            // If user doesn't exist, create them
            $this->createUserFromToken($credentials);
            // Try validation again
            return parent::validate($credentials);
        }
    }

    protected function createUserFromToken(array $credentials)
    {
        $username = $credentials[$this->config['user_provider_credential']] ?? null;

        if (!$username || !$this->decodedToken) {
            throw new UserNotFoundException('Unable to create user: missing required data');
        }

        // Create the user with data from the token
        $this->createUserAction->execute(
            name: $this->decodedToken->name ?? $username,
            email: $this->decodedToken->email ?? $username,
            username: $username,
            keycloakId: $this->decodedToken->sub
        );
    }
}
