<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helper\Helper;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('helper', function(){
            return new Helper();
        });
    }

    public function boot(): void
    {
        //
    }
}
