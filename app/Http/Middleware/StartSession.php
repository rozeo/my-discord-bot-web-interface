<?php


namespace App\Http\Middleware;


use Closure;

class StartSession extends \Illuminate\Session\Middleware\StartSession
{
    public function handle($request, Closure $next)
    {
        $response = parent::handle($request, $next);

        session_write_close();

        return $response;
    }
}