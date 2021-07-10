<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MyAppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('\App\ICSClasses\Helper', function(){
            return new Helper();
        });

        $this->app->singleton('\App\ICSClasses\Directory', function(){
            return new Directory();
        });
    }
}
