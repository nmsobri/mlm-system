<?php

use Mlm\Interfaces\AdminInterface;

class SuperAdminController extends BaseController
{
    protected $repository = null;

    public function __construct( AdminInterface $repository )
    {
        $this->repository = $repository;
    }


    public function index()
    {
        $users = $this->repository->paginateUsers( Input::get( 'page', 1 ),
            Config::get( 'mlm.per_page' ), Auth::user()->id
        );

        return View::make( 'superadmin.index', compact( 'users' ) );
    }


    public function activate()
    {
        $id = Auth::user()->id;
        $user = $this->repository->find( Auth::user()->id );
        return View::make('superadmin.activate', compact('user', 'id'));
    }


    public function postActivate()
    {
        $this->repository->mandatoryPicture();

        if ( !$this->repository->validate( Input::all() ) ) {
            return Redirect::back()->withInput()
                ->withErrors( $this->repository->getValidator() );
        }

        if ( $this->repository->updateUserProfile( Input::all() ) )
        {

            Event::fire('profile.updated',[$this->repository]);
            return Redirect::to( '/admin/super' )
                ->with( 'success', 'Successfully update profile' );
        }

        return Redirect::to( '/admin/super/activate' )
            ->with('error', 'Cant update profile.Please try later');
    }

    public function lists()
    {
        $users = $this->repository->paginateUsers( Input::get( 'page', 1 ),
            Config::get( 'mlm.per_page' ), Auth::user()->id
        );

        return View::make( 'superadmin.lists', compact( 'users' ) );
    }



    public function create()
    {
        $username = $this->repository->generateUsername();
        return View::make( 'superadmin.create', compact('username') );
    }


    public function postCreate()
    {
        if ( !$this->repository->validate( Input::all() ) ) {
            return Redirect::back()->withInput()
                ->withErrors( $this->repository->getValidator() );
        }

        if ( $this->repository->createUser( Input::all() ) ) {
            return Redirect::to( '/admin/super/create' )
                ->with( 'success', 'Successfully create new regular admin' );
        }

        return Redirect::to( '/admin/super/create' )
            ->with('error', 'Cant create regular admin.Please try later' );
    }


    public function update( $id )
    {
        $user = $this->repository->find( $id );
        return View::make('superadmin.update', compact('id', 'user') );
    }


    public function postUpdate()
    {
        if ( !$this->repository->validate( Input::all() ) ) {
            return Redirect::back()->withInput()
                ->withErrors( $this->repository->getValidator() );
        }

        if ( $this->repository->updateUser( Input::all() ) ) {
            return Redirect::to( '/admin/super/update/'. Input::get('id') )
                ->with( 'success', 'Successfully update admin' );
        }

        return Redirect::to( '/admin/super/update/'. Input::get('id') )
            ->with( 'error', 'Cant update admin.Please try later' );
    }


    public function system()
    {
        return View::make('superadmin.system');
    }


    public function postSystem()
    {
        if ( !$this->repository->validate( Input::all() ) ) {
            return Redirect::back()->withInput()
                ->withErrors( $this->repository->getValidator() );
        }

        if ( $this->repository->createSystemAccount( Input::all() ) ) {
            return Redirect::to('/admin/super')->with( 'success',
                'Successfully create system account'
            );
        }

        return Redirect::to( '/admin/super/update/'. Input::get('id') )
            ->with( 'error', 'Cant create system account.Please try later' );
    }


    public function delete( $id )
    {
        if ( $this->repository->deleteUser($id) ) {
            return Redirect::to( '/admin/super')
                ->with( 'success', 'Successfully delete admin' );
        }

        return Redirect::to( '/admin/super' )
            ->with('error', 'Cant delete admin.Please try later' );
    }


    public function profile()
    {
        $id = Auth::user()->id;
        $user = $this->repository->find( Auth::user()->id );
        return View::make('superadmin.profile', compact( 'user', 'id' ) );
    }


    public function postProfile()
    {
        if ( !$this->repository->validate( Input::all() ) ) {
            return Redirect::back()->withInput()
                ->withErrors( $this->repository->getValidator() );
        }

        if ( $this->repository->updateUserProfile( Input::all() ) ) {
            return Redirect::to( '/admin/super/profile' )
                ->with( 'success', 'Successfully update profile' );
        }

        return Redirect::to( '/admin/super/profile' )
            ->with('error', 'Cant update profile.Please try later');
    }


    public function logout()
    {
        Auth::logout();
        return Redirect::to('/login')->with('success', 'Successfully Logout' );
    }
}