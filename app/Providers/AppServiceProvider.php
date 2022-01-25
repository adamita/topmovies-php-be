<?php

namespace App\Providers;

use App\Services\TMDB;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

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
        $this->app->singleton(TMDB::class, function($app){
            return new TMDB(
                  new Client()
                , env('TMDB_API_KEY')
                , env('TMDB_API_URL'));
        });

        $this->app->bind(
            'App\Contracts\TMDBContract',
            TMDB::class
        );
    }
}
