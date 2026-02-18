<?php

namespace Modules\Manager\Providers;

use Illuminate\Support\ServiceProvider;

class ManagerServiceProvider extends ServiceProvider
{
    protected string $name = 'Manager';

    public function boot(): void
    {
        $this->registerViews();
        $this->app->register(RouteServiceProvider::class);
    }

    public function register(): void
    {
        //
    }

    protected function registerViews(): void
    {
        $sourcePath = module_path($this->name, 'resources/views');
        $this->loadViewsFrom($sourcePath, 'manager');
    }
}
