<?php

namespace Mlm\Services;

use SuperAdminReportController;
use RegularAdminReportController;
use UltimateUserReportController;
use RegularUserReportController;

use Illuminate\Support\ServiceProvider;

class MlmReportServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton( 'superadmin.report.interface',
            'Mlm\Repositories\SuperAdminReportRepository'
        );

        $this->app->singleton( 'regularadmin.report.interface',
            'Mlm\Repositories\RegularAdminReportRepository'
        );

        $this->app->singleton('ultimateuser.report.interface',
            'Mlm\Repositories\UltimateUserReportRepository'
        );

        $this->app->singleton('regularuser.report.interface',
            'Mlm\Repositories\RegularUserReportRepository'
        );

        $this->app->bind( 'SuperAdminReportController' , function() {
            return new SuperAdminReportController(
                $this->app->make( 'superadmin.report.interface' )
            );
        });

        $this->app->bind( 'RegularAdminReportController' , function() {
            return new RegularAdminReportController(
                $this->app->make( 'regularadmin.report.interface' )
            );
        });

        $this->app->bind( 'UltimateUserReportController' , function() {
            return new UltimateUserReportController(
                $this->app->make( 'ultimateuser.report.interface' )
            );
        });

        $this->app->bind( 'RegularUserReportController' , function() {
            return new RegularUserReportController(
                $this->app->make( 'regularuser.report.interface' )
            );
        });
    }

    public function boot()
    {

    }
}