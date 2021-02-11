<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\Access\AuthorizationException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    //Overwrite unauthenticated function
    protected function unauthenticated($request, array $guards)
    {
        throw new AuthorizationException(
            'Unauthorization, user is not Authenticated.', $guards, $this->redirectTo($request)
        );
    }
}
