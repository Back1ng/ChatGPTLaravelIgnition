<?php declare(strict_types=1);

namespace Back1ng\ChatGPTLaravelIgnition;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use OpenAI\Client;

final class ServiceProvider extends BaseServiceProvider
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
}