<?php

namespace Back1ng\ChatGPTLaravelIgnition;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use OpenAI\Client;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/back1ng-laravel-ignition.php' => config_path('back1ng-laravel-ignition.php'),
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [
            Client::class,
        ];
    }
}