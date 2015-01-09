<?php

namespace Mlm\Repositories;

use DB;
use Config;
use Mlm\Eloquents\Customer;
use Mlm\Eloquents\Transaction;
use Mlm\Interfaces\AccountInterface;

class UserAccountRepository implements AccountInterface
{

    protected $customer = null;
    protected $transaction = null;

    protected $rules = array(
        'amount' => 'sometimes|required|integer',
    );

    public function __construct(Customer $customer, Transaction $transaction )
    {
        $this->customer = $customer;
        $this->transaction = $transaction;
    }


    public function getAccountPoint( $user_id ) #DONE
    {
        return $this->customer->where( 'user_id', '=', $user_id )
            ->whereNull( 'deleted' )->pluck( 'point' );
    }


    public function validate( $input )
    {
        return $this->customer->validate( $input, $this->rules );
    }


    public function getValidator()
    {
        return $this->customer->getValidator();
    }

    public function validateRequestedAmount( $user_id, $amount )
    {
        $min_payout = Config::get( 'mlm.minimum_point_for_payout' );
        $max_payout = $this->getAccountPoint( $user_id );
        return $amount >= $min_payout and $amount <= $max_payout;
    }

    public function validatePointBalance( $user_id )
    {
        return $this->getAccountPoint( $user_id ) >=
            Config::get( 'mlm.minimum_account_balance' );
    }


    public function savePayoutRequest( $user_id, $amount )
    {
        return DB::transaction( function() use ( $user_id, $amount ) {

            $this->transaction->create( array(
                    'requestor_id' => $user_id, 'amount' => $amount,
                    'created' => DB::raw( 'NOW()' ) )
            );

            return DB::update( "UPDATE customers SET point = point - ?
                        WHERE user_id = ?", array( $amount, $user_id )
            );
        });
    }


    public function isExistingRequest( $user_id ) #DONE
    {
        return $this->transaction->where( 'requestor_id', '=', $user_id )
            ->where( 'status', '=', 'new' )->whereNull( 'deleted' )
            ->get()->count() > 0;
    }


    public function paginateUserTransaction( $user_id ) #DONE
    {
        return $this->transaction->where( 'requestor_id', '=', $user_id )
            ->whereNull( 'deleted' )->paginate( Config::get( 'mlm.per_page' ) );
    }
}