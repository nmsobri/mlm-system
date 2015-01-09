<?php

namespace Mlm\Interfaces;

interface AccountInterface
{
    public function getAccountPoint( $user_id );

    public function validate( $input );

    public function getValidator();

    public function validateRequestedAmount( $user_id, $amount );

    public function validatePointBalance( $user_id );

    public function savePayoutRequest( $user_id, $amount );

    public function isExistingRequest( $user_id );

    public function paginateUserTransaction( $user_id );
}