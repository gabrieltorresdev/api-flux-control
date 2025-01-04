<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class KeycloakAuthenticate extends Middleware
{
    protected function authenticate($request, array $guards): void
    {
        if (empty($guards)) {
            $guards = ['api'];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return;
            }
        }

        $this->unauthenticated($request, $guards);
    }

    protected function redirectTo(Request $request): ?string
    {
        return null;
    }
}
