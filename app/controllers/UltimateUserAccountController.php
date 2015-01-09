<?php

use Mlm\Interfaces\AccountInterface;

class UltimateUserAccountController extends BaseController
{
    protected $repository = null;

    public function __construct( AccountInterface $repository )
    {
        $this->repository = $repository;
    }


    public function index()
    {
        $transactions = $this->repository
            ->paginateUserTransaction( Auth::user()->id );

        $point = $this->repository->getAccountPoint( Auth::user()->id );

        return View::make( 'ultimateuser.account.index',
            compact( 'point','transactions' )
        );
    }


    public function payment()
    {
        return View::make( 'ultimateuser.account.payment' );
    }


    public function postPayment()
    {
        if ( !$this->repository->validate( Input::all() ) ) {
            return Redirect::back()->withInput()
                ->withErrors( $this->repository->getValidator() );
        }

        if ( $this->repository->isExistingRequest( Auth::user()->id) ) {
            return Redirect::back()->with( 'error',
                'You already have new request waiting to be process'
            );
        }

        if ( !$this->repository->validatePointBalance( Auth::user()->id ) ) {
            $minimum_balance = Config::get( 'mlm.minimum_account_balance' );

            return Redirect::back()->with( 'error',
                "Insufficient account balance.
                You must have atleast {$minimum_balance} point before proceed"
            );
        }

        if ( !$this->repository->validateRequestedAmount( Auth::user()->id,
            Input::get( 'amount' ) ) )
        {
            $point = $this->repository->getAccountPoint( Auth::user()->id );
            $minimum_payout = Config::get( 'mlm.minimum_point_for_payout' );

            return Redirect::back()->with( 'error',
                "Your requested ammount should between
                {$minimum_payout} and {$point}"
            );
        }

        if ( $this->repository->savePayoutRequest( Auth::user()->id,
            Input::get( 'amount' ) ) )
        {
            return Redirect::to( '/user/ultimate/account/payment' )
                ->with( 'success', 'Successfull request for payout.
                        Your request will be process by admin soon'
            );
        }
    }

}
