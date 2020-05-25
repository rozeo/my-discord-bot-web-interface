<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Rozeo\DiscordAuthorizer;

class DiscordAuthMiddleware
{
    /**
     * @var DiscordAuthorizer
     */
    private $auth;
    /**
     * @var Application
     */
    private $app;

    public function __construct(Application $app, DiscordAuthorizer $auth)
    {
        $this->app = $app;
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
        if (!$request->session()->get('token')) {
            return redirect($this->auth->getRedirectUri());
        }

        // set current token data
        $this->auth->setToken($request->session()->get('token'));

        // token update
        if (($token = $this->auth->refresh())) {
            $request->session()->put('token', $this->auth->getToken());
        }

        return $next($request);
    }
}
