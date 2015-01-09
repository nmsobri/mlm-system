<?php

namespace Mlm\Repositories;

use DB;
use Pdf;
use View;
use Excel;
use Mlm\Interfaces\AdminReportInterface;

class SuperAdminReportRepository implements AdminReportInterface
{

    public function userExcel( $user_id = null )
    {
        $users = $this->getUserList();
        Excel::create( 'users', function( $excel ) use( $users ) {

            $excel->sheet( 'New sheet', function($sheet) use ( $users ) {

                $sheet->loadView( 'superadmin.report.excel.users' ,
                    [ 'users'=>$users ]
                );
            });

        })->download( 'xls' );
    }


    public function userPdf( $user_id = null )
    {
        $users = $this->getUserList();
        $view = View::make( 'superadmin.report.pdf.users', compact( 'users' ) );
        return Pdf::load( $view, 'A4', 'portrait')->download( 'users' );
    }


    public function transactionExcel()
    {
        $transactions = $this->getTransactions();
        Excel::create( 'transactions', function( $excel ) use( $transactions ) {

            $excel->sheet( 'New sheet', function($sheet) use ( $transactions ) {

                $sheet->loadView( 'superadmin.report.excel.transactions' ,
                    [ 'transactions' => $transactions ]
                );
            });

        })->download( 'xls' );
    }


    public function transactionPdf()
    {
        $transactions = $this->getTransactions();
        $view = View::make( 'superadmin.report.pdf.transactions', compact( 'transactions' ) );
        return Pdf::load( $view, 'A4', 'portrait' )->download( 'transactions' );
    }


    protected function getUserList()
    {
        return DB::select('
                    SELECT d.*, au.username as super_admin_username,
                    ap.full_name as super_admin_fullname
                    FROM
                    (
                        SELECT
                                u.id, u.username, u.`status`, u.groups, u.last_login,
                                p.user_id, p.full_name, p.ic_num, p.gender, p.contact_num,
                                p.picture, p.created_date AS appointed_date, a.admin_id
                        FROM users u
                        INNER JOIN `profiles` p ON u.id = p.user_id
                        LEFT JOIN admins a ON u.id = a.user_id
                        WHERE u.deleted IS NULL
                    ) d

                    LEFT JOIN users au ON au.id = d.admin_id
                    LEFT JOIN `profiles` ap ON ap.user_id = au.id
                    ORDER BY d.id'
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