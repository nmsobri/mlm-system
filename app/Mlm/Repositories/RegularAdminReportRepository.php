<?php

namespace Mlm\Repositories;

use DB;
use Pdf;
use View;
use Excel;
use Mlm\Interfaces\AdminReportInterface;

class RegularAdminReportRepository implements AdminReportInterface
{

    public function userExcel( $user_id = null )
    {
        $users = $this->getUserList( $user_id );
        Excel::create( 'users', function( $excel ) use( $users ) {

            $excel->sheet( 'New sheet', function($sheet) use ( $users ) {

                $sheet->loadView( 'regularadmin.report.excel.users' ,
                    [ 'users'=>$users ]
                );
            });

        })->download( 'xls' );
    }


    public function userPdf( $user_id = null )
    {
        $users = $this->getUserList( $user_id );
        $view = View::make( 'regularadmin.report.pdf.users', compact( 'users' ) );
        return Pdf::load( $view, 'A4', 'portrait')->download( 'users' );
    }


    public function transactionExcel()
    {
        $transactions = $this->getTransactions();
        Excel::create( 'transactions', function( $excel ) use( $transactions ) {

            $excel->sheet( 'New sheet', function($sheet) use ( $transactions ) {

                $sheet->loadView( 'regularadmin.report.excel.transactions' ,
                    [ 'transactions' => $transactions ]
                );
            });

        })->download( 'xls' );
    }


    public function transactionPdf()
    {
        $transactions = $this->getTransactions();
        $view = View::make( 'regularadmin.report.pdf.transactions', compact( 'transactions' ) );
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
                FROM users u
                INNER JOIN profiles p
                        On u.id = p.user_id
                INNER JOIN customers c
                        ON u.id = c.user_id
                INNER JOIN downlines d
                        ON u.id = d.downline_user_id
                INNER JOIN users upline
                        ON d.upline_user_id = upline.id
                INNER JOIN `profiles` upline_profiles
                        ON d.upline_user_id = upline_profiles.user_id
                WHERE d.upline_user_id = ? AND u.deleted IS NULL
                ORDER BY u.id', [ $user_id ]
        );
    }


    protected function getTransactions()
    {
        return DB::select('
                SELECT t.*, u.username processor_username,
                p.full_name processor_fullname
                FROM `transactions` t
                LEFT JOIN users u on t.processor_id = u.id
                LEFT JOIN `profiles` p on t.processor_id = p.user_id
                WHERE t.deleted is null'
        );
    }


}