<?php

namespace JSefton\Protocol;

use Illuminate\Support\ServiceProvider;

class ProtocolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Configuration
        $this->publishes([
            __DIR__.'/../config/' => config_path(),
        ], 'protocol.config');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
