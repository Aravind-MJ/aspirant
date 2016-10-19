<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('check_unique', function($attribute, $value, $parameters, $validator) {
            $md5 = md5($value.$parameters[0]);
            
            if(!empty($value) && (strlen($value) % 2) == 0){
                return true;
            }
                return false;
        });
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
