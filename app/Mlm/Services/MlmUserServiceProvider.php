<?php

namespace Mlm\Services;

use RegularUserController;
use UltimateUserController;
use Illuminate\Support\ServiceProvider;

class MlmUserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton( 'regularuser.interface',
            'Mlm\Repositories\RegularUserRepository'
        );

        $this->app->bind( 'RegularUserController' , function() {
            return new RegularUserController(
                $this->app->make( 'regularuser.interface' )
            );
        });

        $this->app->singleton( 'ultimateuser.interface',
            'Mlm\Repositories\UltimateUserRepository'
        );

        $this->app->bind( 'UltimateUserController' , function() {
            return new UltimateUserController(
                $this->app->make( 'ultimateuser.interface' )
            );
        });
    }

    public function boot()
    {

    }
}