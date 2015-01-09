<?php

namespace Mlm\Interfaces;

interface TransactionInterface
{
    public function paginateTransaction( $page, $per_page );

    public function validate( $input );

    public function getValidator();

    public function findTransaction( $id );

    public function updateTransaction( $input, $user_id );

    public function issufficeAccountPoint( $input );

}