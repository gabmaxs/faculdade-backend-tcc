<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\ResponseService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton("Response", function ($app) {
            return new ResponseService();
        });
    }
}
