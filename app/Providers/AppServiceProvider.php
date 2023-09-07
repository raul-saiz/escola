<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


            if (app()->environment('remote')) {
                URL::forceScheme('https');
            }

        Builder::macro('search', function($field,$string) {
           // return $string ? $this->where($field,'like', '%'.$string.'%') : $this;
            return $string ? $this->where($field,'like', $string.'%') : $this;
        });
    }
}
