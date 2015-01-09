<?php

namespace Mlm\Repositories;

use DB;
use Pdf;
use View;
use Excel;
use Config;
use Mlm\Eloquents\Transaction;
use Mlm\Interfaces\UserReportInterface;

class RegularUserReportRepository implements UserReportInterface
{
    protected $transaction = null;

    public function __construct( Transaction $transaction )
    {
        $this->transaction = $transaction;
    }


    public function userExcel( $user_id )
    {
        $users = $this->getUserList( $user_id );
        Excel::create( 'users', function( $excel ) use( $users ) {

            $excel->sheet( 'New sheet', function($sheet) use ( $users ) {

                $sheet->loadView( 'regularuser.report.excel.users' ,
                    [ 'users'=>$users ]
                );
            });

        })->download( 'xls' );
    }


    public function userPdf( $user_id )
    {
        $users = $this->getUserList( $user_id );
        $view = View::make( 'regularuser.report.pdf.users', compact( 'users' ) );
        return Pdf::load( $view, 'A4', 'portrait')->download( 'users' );
    }


    public function transactionExcel( $user_id )
    {
        $transactions = $this->getTransactions( $user_id );
        Excel::create( 'transactions', function( $excel ) use( $transactions ) {

            $excel->sheet( 'New sheet', function($sheet) use ( $transactions ) {

                $sheet->loadView( 'regularuser.report.excel.transactions' ,
                    [ 'transactions' => $transactions ]
                );
            });

        })->download( 'xls' );
    }


    public function transactionPdf( $user_id )
    {
        $transactions = $this->getTransactions( $user_id );
        $view = View::make( 'regularuser.report.pdf.transactions', compact( 'transactions' ) );
        return Pdf::load( $view, 'A4', 'portrait' )->download( 'transactions' );
    }


    protected function getUserList( $user_id )
    {
        return DB::select('
                SELECT
                    u.id, u.username, u.`status`, u.groups, u.last_login,
                    p.user_id, p.full_name, p.ic_num, p.gender, p.contact_num,
                    p.picture, p.created_date as appointed_date, c.heir_name,
                    c.heir_contact_num, c.bank_account, c.account_num, d.*,
                    upline.username upline_username,
                    upline_profiles.full_name upline_fullname
                FROM users u INNER JOIN profiles p On u.id = p.user_id
                INNER JOIN customers c ON u.id = c.user_id
                INNER JOIN downlines d ON u.id = d.downline_user_id
                INNER JOIN users upline ON d.upline_user_id = upline.id
                INNER JOIN `profiles` upline_profiles
                ON d.upline_user_id = upline_profiles.user_id
                WHERE d.upline_user_id = ? and u.deleted IS NULL
                ORDER BY u.id', [ $user_id ]
        );
    }


    protected function getTransactions( $user_id )
    {
        return $this->transaction->where( 'requestor_id', '=', $user_id )
            ->whereNull( 'deleted' )->paginate( Config::get( 'mlm.per_page' ) );
    }

}