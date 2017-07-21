<?php

namespace nalfarenas\userstmp;

use Illuminate\Support\ServiceProvider;

use nalfarenas\UsersTmp\UserTempStorage;

use nalfarenas\UsersTmp\UserStorage;

use Auth;

class userstmpServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('UsersTmp', function ($app) {

            return new UserTempStorage();
        });

        $this->app->singleton('UsersTmpWeb', function ($app) {

            $user = Auth::user();

            return new UserStorage($user);
        });
    }
}