<?php

namespace Mlm\Services;

use Log;
use Event;
use Auth;
use Config;
use Validator;
use Mlm\Libs\Auth\MlmAuthGuard;
use Mlm\Libs\Auth\MlmUserProvider;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\ServiceProvider;

class MlmServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton( 'Mlm\Interfaces\HomeInterface',
            'Mlm\Repositories\HomeRepository'
        );

        $this->app->singleton( 'Mlm\Interfaces\AccountInterface',
            'Mlm\Repositories\UserAccountRepository'
        );

        $this->app->singleton( 'Mlm\Interfaces\TransactionInterface',
            'Mlm\Repositories\TransactionRepository'
        );
    }

    public function boot()
    {
        Auth::extend( 'mlm.auth', function() {
            return new MlmAuthGuard( new MlmUserProvider( new BcryptHasher,
                    Config::get( 'auth.model' ) ),
                $this->app->make( 'session.store' )
            );
        });

        Validator::extend('alpha_spaces', function( $attribute, $value ) {
            return preg_match( '#^[\pL\s\.]+$#u', $value );
        });

        Event::listen( 'profile.updated', function( $repo ) {
            $repo->updateLastLogin();
        });

        Event::listen( 'regular.user.created', function( $repo, $user) {
            $repo->addUplinesPoint( $user );
        });

        Event::listen( 'illuminate.query', function( $query, $params, $time, $conn ) {
            Log::info( array( $query, $params, $time, $conn ) );
        });
    }
}