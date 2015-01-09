<?php

use Mlm\Interfaces\UserInterface;

class RegularUserController extends BaseController
{
    protected $repository = null;

    public function __construct( UserInterface $repository )
    {
        $this->repository = $repository;
    }


    public function index()
    {
        $users = $this->repository->paginateUsers( Input::get('page', 1),
            Config::get('mlm.per_page'),
            Auth::user()->id
        );

        return View::make( 'regularuser.index', compact( 'users' ) );
    }


    public function activate()
    {
        $id = Auth::user()->id;
        $user = $this->repository->find( Auth::user()->id );
        return View::make( 'regularuser.activate', compact( 'id', 'user' ) );
    }


    public function postActivate()
    {
        $this->repository->mandatoryPicture();
        if ( !$this->repository->validate( Input::all() ) ) {
            return Redirect::back()->withInput()
                ->withErrors( $this->repository->getValidator() );
        }

        if ( $this->repository->updateUserProfile( Input::all() ) ) {

            Event::fire( 'profile.updated', [$this->repository] );
            return Redirect::to( '/user/regular' )
                ->with( 'success', 'Successfully update profile' );
        }

        return Redirect::to( '/user/regular/activate' )
            ->with('error', 'Cant update profile.Please try later');
    }


    public function lists()
    {
        $users = $this->repository->paginateUsers( Input::get( 'page', 1 ),
            Config::get( 'mlm.per_page' ),
            Auth::user()->id
        );
        return View::make( 'regularuser.lists', compact( 'users' ) );
    }


    public function create()
    {
        return View::make( 'regularuser.create' );
    }


    public function postCreate()
    {
        if ( !$this->repository->validate( Input::all() ) ) {
            return Redirect::back()->withInput()
                ->withErrors( $this->repository->getValidator() );
        }

        if ( $this->repository->isMaxDownline( Auth::user()->id ) ) {
            return Redirect::to( '/user/regular/create' )
                ->with( 'error', 'You cant add new downline.
                You already reached max downline limit' );
        }

        if ( $user = $this->repository->createUser( Input::all() ) ) {

            Event::fire( 'regular.user.created', [ $this->repository, $user ] );
            return Redirect::to( '/user/regular/create' )
                ->with( 'success', 'Successfully create new regular user' );
        }

        return Redirect::to( '/user/regular/create' )
            ->with('error', 'Cant create regular user.Please try later');
    }


    public function update( $id )
    {
        $user = $this->repository->findCustomer( $id );
        return View::make( 'regularuser.update', compact( 'id', 'user' ) );
    }


    public function postUpdate()
    {
        if ( !$this->repository->validate( Input::all() ) ) {
            return Redirect::back()->withInput()
                ->withErrors( $this->repository->getValidator() );
        }

        if ( $this->repository->updateUser( Input::all() ) ) {
            return Redirect::to( '/user/regular/update/'. Input::get('id') )
                ->with( 'success', 'Successfully update user' );
        }

        return Redirect::to( '/user/regular/update/'. Input::get('id') )
            ->with('error', 'Cant update user.Please try later');
    }


    public function delete( $id )
    {
        if ( $this->repository->deleteUser( $id ) ) {
            return Redirect::to( '/user/regular')
                ->with( 'success', 'Successfully delete user' );
        }

        return Redirect::to( '/user/ultimate' )
            ->with('error', 'Cant delete user.Please try later');
    }


    public function profile()
    {
        $id = Auth::user()->id;
        $user = $this->repository->find( Auth::user()->id );
        return View::make('regularuser.profile', compact( 'user', 'id' ) );
    }


    public function postProfile()
    {
        if ( !$this->repository->validate( Input::all() ) ) {
            return Redirect::back()->withInput()
                ->withErrors( $this->repository->getValidator() );
        }

        if ( $this->repository->updateUserProfile( Input::all(), 'profile' ) ) {
            return Redirect::to( '/user/regular/profile' )
                ->with( 'success', 'Successfully update profile' );
        }

        return Redirect::to( '/user/regular/profile' )
            ->with('error', 'Cant update profile.Please try later');
    }


    public function logout()
    {
        Auth::logout();
        return Redirect::to('/login')->with( 'success', 'Successfully Logout' );
    }
}