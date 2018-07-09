<?php

namespace App\Providers;

use App\Services\CurrencyBuilder;
use App\Services\CurrencyRepository;
use App\Services\CurrencyRepositoryInterface;
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
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CurrencyRepositoryInterface::class,function($app){ 
            return new CurrencyRepository();
        });
        $this->app->singleton(CurrencyBuilder::class,function($app){
            return new CurrencyBuilder();
        });
    }
}
