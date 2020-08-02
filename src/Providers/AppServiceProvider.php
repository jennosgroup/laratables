<?php

namespace Laratables\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../public' => public_path('vendor/laratables'),
        ], 'laratables-assets');

        $this->publishes([
            __DIR__. '/../../resources/views' => resource_path('views/vendor/laratables'),
        ], 'laratables-views');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'laratables');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
