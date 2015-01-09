<?php

namespace Mlm\Interfaces;

interface AdminReportInterface
{
    public function userExcel( $user_id = null );

    public function userPdf( $user_id = null );

    public function transactionExcel();

    public function transactionPdf();
}