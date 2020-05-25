<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MongoDB\Driver\Session;
use Rozeo\DiscordAuthorizer;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\SessionHandlerFactory;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DiscordAuthorizer::class, function () {
            $auth = new DiscordAuthorizer(
                config('discord.id'),
                config('discord.secret')
            );

            return $auth->addScopes('identify')
                ->addScopes('guilds')
                ->setCallback(route('oauth.callback'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
