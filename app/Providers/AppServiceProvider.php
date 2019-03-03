<?php

namespace App\Providers;

use Validator;
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
        Validator::extend('allowed_files', function($attribute, $value, $parameters) {
            $allowed_mimes = [
                'image/gif', // gif
                'image/jpeg', // jpeg or jpg
                'image/png', // png
                'application/pdf', // pdf
            ];

            return in_array($value->getClientMimeType(), $allowed_mimes);
        }, 'Only image and pdf files are allowed');
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
