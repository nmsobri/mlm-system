<?php

namespace Mlm\Services;

use SuperAdminController;
use RegularAdminController;
use Illuminate\Support\ServiceProvider;

class MlmAdminServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton( 'superadmin.interface',
            'Mlm\Repositories\SuperAdminRepository'
        );

        $this->app->bind( 'SuperAdminController' , function() {
            return new SuperAdminController(
                $this->app->make( 'superadmin.interface' )
            );
        });


        $this->app->singleton( 'regularadmin.interface',
            'Mlm\Repositories\RegularAdminRepository'
        );

        $this->app->bind( 'RegularAdminController' , function() {
            return new RegularAdminController(
                $this->app->make( 'regularadmin.interface' )
            );
        });
    }

    public function boot()
    {

    }
}