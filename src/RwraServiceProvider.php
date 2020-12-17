<?php

namespace edgewizz\rwra;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class RwraServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Edgewizz\Rwra\Controllers\RwraController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // dd($this);
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__ . '/components', 'rwra');
        Blade::component('rwra::rwra.open', 'rwra.open');
        Blade::component('rwra::rwra.index', 'rwra.index');
        Blade::component('rwra::rwra.edit', 'rwra.edit');
    }
}
