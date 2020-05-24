<?php

namespace App\Http\Middleware;

use Closure;
use Rozeo\DiscordAuthorizer;

class DiscordAuthMiddleware
{
    /**
     * @var DiscordAuthorizer
     */
    private DiscordAuthorizer $auth;

    public function __construct(DiscordAuthorizer $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->session()->get('auth_data')) {
            return redirect($this->auth->getRedirectUri());
        }

        return $next($request);
    }
}
