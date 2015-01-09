<?php

namespace Mlm\Repositories;

use DB;
use Config;
use Paginator;
use Mlm\Eloquents\Customer;
use Mlm\Eloquents\Transaction;
use Mlm\Interfaces\TransactionInterface;

class TransactionRepository implements TransactionInterface
{

    protected $transaction = null;
    protected $customer = null;

    protected $rules = array(
        'status' => 'sometimes|required',
        'comment' => 'sometimes|alpha_spaces'
    );

    public function __construct(  Transaction $transaction, Customer $customer )
    {
        $this->transaction = $transaction;
        $this->customer= $customer;
    }


    public function paginateTransaction( $page, $per_page ) #DONE
    {
        $page = ( $page - 1 ) * $per_page;
        $transactions = DB::select('
                SELECT t.*, u.username processor_username,
                p.full_name processor_fullname
                FROM `transactions` t
                LEFT JOIN users u on t.processor_id = u.id
                LEFT JOIN `profiles` p on t.processor_id = p.user_id
                WHERE t.deleted is null
                LIMIT ?,?', [ $page, $per_page ]
        );

        return Paginator::make( $transactions, $this->getTransactionCount(),
            $per_page
        );
    }


    public function getValidator()
    {
        return $this->transaction->getValidator();
    }


    public function validate( $input )
    {
        return $this->transaction->validate( $input, $this->rules );
    }


    public function findTransaction( $id ) #DONE
    {
        return DB::select('
                SELECT t.*, u.username processor_username,
                p.full_name processor_fullname
                FROM `transactions` t
                LEFT JOIN users u on t.processor_id = u.id
                LEFT JOIN `profiles` p on t.processor_id = p.user_id
                WHERE t.id = ? AND t.deleted IS NULL', [ $id ]
        )[0];
    }


    public function issufficeAccountPoint( $input ) #DONE
    {
        $point = DB::select('
                        SELECT point from customers c WHERE c.user_id = ?
                        AND c.deleted IS NULL
                            UNION	all
                        SELECT amount from transactions t WHERE id = ?
                        AND t.deleted IS NULL',
            [ Config::get('mlm.system_id'), $input['id'] ]
        );

        if ( $input['status'] !='approved' ) return true;

        return $point[0]->point > $point[1]->point;
    }


    public function updateTransaction( $input, $user_id ) #done
    {
        if ( $input['status'] == 'rejected' ) {
            $this->reAddCustomerPoint( $input );
        }

        if ( $input['status'] == 'approved' ) {
            $this->deductCompanyPoint( $input );
        }

        $transaction = $this->transaction->find( $input['id'] )
            ->whereNull( 'deleted' )->getModel();

        $transaction->processor_id = $user_id;
        $transaction->status = $input['status'];
        $transaction->comment = $input['comment'];
        $transaction->processed = DB::raw( 'NOW()' );
        return $transaction->save();
    }


    protected function reAddCustomerPoint( $input ) #DONE
    {
        $transaction = $this->transaction->find( $input['id'] )
            ->whereNull( 'deleted' )->getModel();

        $customer = $this->customer->find( $transaction->requestor_id )
            ->whereNull( 'deleted' )->getModel();

        $customer->point = $customer->point + $transaction->amount;
        return $customer->save();
    }


    protected function deductCompanyPoint( $input )
    {
        $transaction = $this->transaction->find( $input['id'] )
            ->whereNull( 'deleted' )->getModel();

        $customer = $this->customer->find( Config::get( 'mlm.system_id' ) )
            ->whereNull( 'deleted' )->getModel();

        $customer->point = $customer->point - $transaction->amount;
        return $customer->save();
    }


    protected function getTransactionCount() #done
    {
        return $this->transaction->whereNull( 'deleted' )->count();
    }
}