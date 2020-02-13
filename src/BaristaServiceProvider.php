<?php

namespace Barista;

use Barista\Commands\PrepareAPI;
use Illuminate\Support\ServiceProvider;

class BaristaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([PrepareAPI::class]);
    }
}
