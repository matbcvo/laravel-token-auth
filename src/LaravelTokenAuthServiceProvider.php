<?php

namespace Matbcvo\LaravelTokenAuth;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Matbcvo\LaravelTokenAuth\Console\Commands\CreateApiToken;
use Matbcvo\LaravelTokenAuth\Console\Commands\DeleteApiToken;
use Matbcvo\LaravelTokenAuth\Console\Commands\ListApiTokens;
use Matbcvo\LaravelTokenAuth\Http\Middleware\AuthenticateApiToken;

class LaravelTokenAuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-token-auth.php', 'laravel-token-auth');
    }

    public function boot(): void
    {
        $this->offerPublishing();

        $this->registerMiddleware();

        $this->registerCommands();
    }

    protected function offerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/laravel-token-auth.php' => config_path('laravel-token-auth.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'migrations');
        }
    }

    protected function registerMiddleware(): void
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('auth.token', AuthenticateApiToken::class);
    }

    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateApiToken::class,
                DeleteApiToken::class,
                ListApiTokens::class,
            ]);
        }
    }
}
