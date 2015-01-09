<?php

use Mlm\Interfaces\TransactionInterface;

class RegularAdminTransactionController extends BaseController
{
    protected $repository = null;

    public function __construct( TransactionInterface $repository )
    {
        $this->repository = $repository;
    }


    public function index()
    {
        $transactions = $this->repository
            ->paginateTransaction( Input::get( 'page', 1 ),
                Config::get( 'mlm.per_page' )
            );

        return View::make( 'regularadmin.transaction.index',
            compact( 'transactions')
        );
    }


    public function process( $id )
    {
        $transaction = $this->repository->findTransaction( $id );

        return View::make( 'regularadmin.transaction.process',
            compact( 'id', 'transaction' )
        );
    }


    public function postProcess()
    {
        if ( !$this->repository->validate( Input::all() ) ) {
            return Redirect::back()->withInput()
                ->withErrors( $this->repository->getValidator() );
        }

        if ( !$this->repository->issufficeAccountPoint( Input::all() ) ) {
            return Redirect::back()->with( 'error',
                'Company point is insufficient to proceed'
            );
        }

        if ( $this->repository->updateTransaction( Input::all(),
            Auth::user()->id ) )
        {
            return Redirect::back()
                ->with( 'success', 'Success updating transaction' );
        }

    }


}
