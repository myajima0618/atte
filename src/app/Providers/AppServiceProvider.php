<?php

namespace App\Providers;

//use Illuminate\Support\Facades\Password;
use Illuminate\Support\ServiceProvider;

use Illuminate\Validation\Rules\Password;

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
        // passwordデフォルト設定
        Password::defaults(function() {
            return Password::min(8)
                        ->letters()
                        ->numbers();
        });
    }
}
