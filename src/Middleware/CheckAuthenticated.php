<?php

namespace JaguarJack\CatchAdmin\Middleware;

use JaguarJack\CatchAdmin\Exceptions\AuthenticatedFailedException;
use JaguarJack\CatchAdmin\Exceptions\FailedException;
use Closure;

class CheckAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        try {
            if (!$guard) {
                throw new FailedException('Guard missing');
            }

            $request->guard = $guard;

            $user = $request->user($guard);

            if (!$user) {
                throw new AuthenticatedFailedException();
            }
        } catch (\Exception $exception) {
            throw new AuthenticatedFailedException($exception->getMessage());
        }

        return $next($request);
    }
}
