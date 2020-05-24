<?php


namespace App\Http\Middleware;

use Closure;

class DiscordNoLoginMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->session()->get('auth_data')) {
            return redirect()
                ->route('home');
        }

        return $next($request);
    }
}