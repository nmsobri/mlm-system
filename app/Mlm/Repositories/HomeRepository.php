<?php

namespace Mlm\Repositories;

use DB;
use Auth;
use Mlm\Eloquents\User;
use Mlm\Interfaces\HomeInterface;

class HomeRepository implements HomeInterface
{
    protected $user = null;

    protected $account_active = true;

    protected $system_page = 'admin/super/create/system';

    protected $landing_page = array( 'super_admin'=>'admin/super',
        'regular_admin' => 'admin/regular', 'ultimate_user'=>'user/ultimate',
        'regular_user' => 'user/regular'
    );

    protected $activation_page = array( 'super_admin'=>'admin/super/activate',
        'regular_admin' => 'admin/regular/activate',
        'ultimate_user' => 'user/ultimate/activate',
        'regular_user' => 'user/regular/activate'
    );

    protected $transaction_page = array(
        'super_admin' => 'admin/super/transaction',
        'regular_admin' => 'admin/regular/transaction',
        'ultimate_user' => null,
        'regular_user' => null
    );

    protected $rules = array( 'username' => 'required|min:4',
        'password' => 'required|min:6'
    );

    public function __construct( User $user )
    {
        $this->user = $user;
    }


    public function attemptLogin( array $input, $remember )
    {
        $credential = array( 'username' => $input['username'],
            'password' => $input['password'], 'status' => 'active',
            'deleted' => array(
                'operator' => 'IS',
                'value' => Db::raw( 'NULL' )
            )
        );

        if ( !Auth::attempt( $credential, $remember ) ) {

            $credential = array( 'username' => $input['username'],
                'password' => $input['password'],
                'deleted' => array(
                    'operator' => 'IS',
                    'value' => Db::raw( 'NULL' )
                )
            );

            if ( Auth::validate( $credential ) ) {
                $this->account_active = false;
            }
            return false;
        }
        return $this->setPage();
    }


    public function validate( $input )
    {
        return $this->user->validate( $input, $this->rules );
    }


    public function getValidator()
    {
        return $this->user->getValidator();
    }


    public function isAccountActive()
    {
        return $this->account_active;
    }


    public function landingPage( $group )
    {
        return $this->landing_page[$group];
    }


    protected function setPage()
    {
        Auth::set( 'system.page', $this->system_page );
        Auth::set( 'landing.page', $this->landing_page[Auth::user()->groups] );
        Auth::set( 'activation.page', $this->activation_page[Auth::user()->groups] );
        Auth::set( 'transaction.page', $this->transaction_page[Auth::user()->groups] );
        return true;
    }

}