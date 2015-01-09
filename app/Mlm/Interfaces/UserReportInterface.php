<?php

namespace Mlm\Interfaces;

interface UserReportInterface
{
    public function userExcel( $user_id );

    public function userPdf( $user_id );

    public function transactionExcel( $user_id );

    public function transactionPdf( $user_id );
}