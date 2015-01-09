<?php

use Mlm\Interfaces\HomeInterface;

class HomeController extends BaseController
{
    protected $repository = null;

    public function __construct( HomeInterface $repository )
    {
        $this->repository = $repository;
    }


	public function index()
	{
		return View::make( 'home.index' );
	}


    public function login()
    {
        return View::make( 'home.login' );
    }


    public function postLogin()
    {
        if ( !$this->repository->validate( Input::all() ) ) {
            return Redirect::back()
                ->withErrors( $this->repository->getValidator() );
        }

        if ( $this->repository->attemptLogin( Input::all(),
            Input::has('remember') ) ) {

            return Redirect::intended( $this->repository->landingPage(
                Auth::user()->groups )
            );
        }

        if ( !$this->repository->isAccountActive() ) {
            return Redirect::back()
                ->with( 'error', 'Your account is not active' );
        }

        return Redirect::back()
            ->with( 'error', 'No such username and password combination' );
    }

}
