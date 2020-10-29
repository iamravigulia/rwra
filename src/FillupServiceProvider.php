<?php

namespace edgewizz\fillup;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class FillupServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Edgewizz\Fillup\Controllers\FillupController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // dd($this);
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__ . '/components', 'fillup');
        Blade::component('fillup::form.open', 'form.open');
        // $this->loadViewsFrom(__DIR__ . '/components', 'fillup');
        // Blade::component('fillup::ques.create', 'ques.create');
        // $this->loadViewComponentsAs('fillup', [
        //     'store.blade.php',
        // ]);
    }
}
