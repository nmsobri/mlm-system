<?php

use Mlm\Eloquents\Transaction;

App::before(function($request){});


App::after(function($request, $response){});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login')->with('error', 'Please login first');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if ( Auth::check() ) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter( 'csrf', function() {
	if ( Session::token() !== Input::get( '_token' ) ) {
		throw new Illuminate\Session\TokenMismatchException;
	}
});


Route::filter( 'new.user', function() {
    if ( is_null( Auth::user()->last_login ) ) {
        return Redirect::to( Auth::get( 'activation.page' ) )
            ->with( 'notice', 'You need to update your profile before continue' );
    }
});


Route::filter( 'existing.user', function(){
    if ( Auth::user()->last_login  ) {
        return Redirect::to( Auth::get( 'landing.page' ) );
    }
});


Route::filter( 'new.system', function(){
    if ( !Config::get( 'mlm.system_id' ) && !Session::get( 'system_id' ) )  {
        Session::reflash();
        return Redirect::to( Auth::get( 'system.page' ) )
            ->with( 'notice', 'Please take a moment to create system account.This
            account will act as system account for point calculation'
        );
    }
});


Route::filter( 'existing.system', function() {
    $conf = Config::get( 'mlm.system_id' );
    if ( !is_null( $conf ) ) {
        return Redirect::to( Auth::get( 'landing.page' ) );
    }
});


Route::filter( 'transaction.complete', function( $route ) {
    $id = Input::get( 'id', $route->getParameter( 'id' ) );
    $transaction = Transaction::find( $id );

    if ( in_array( $transaction->status,['approved', 'rejected'] ) &&
        !Session::get('stay') )
    {
        return Redirect::to( Auth::get( 'transaction.page' ) );
    }

});