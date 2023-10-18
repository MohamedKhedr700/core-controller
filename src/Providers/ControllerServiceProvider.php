<?php

namespace Raid\Core\Controller\Providers;

use Illuminate\Support\ServiceProvider;
use Raid\Core\Controller\Traits\Provider\WithControllerProvider;

class ControllerServiceProvider extends ServiceProvider
{
    use WithControllerProvider;

    /**
     * The commands to be registered.
     */
    protected array $commands = [];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerCommands();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
