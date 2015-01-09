<?php

namespace Mlm\Interfaces;

interface AdminInterface
{
    public function getValidator();

    public function validate( $input );

    public function createUser( $input );

    public function generateUsername();

    public function paginateUsers( $page, $per_page, $user_id );

    public function find( $id );

    public function updateUser( $input );

    public function deleteUser( $id );

    public function updateUserProfile( $input );

    public function updateLastLogin();

    public function mandatoryPicture();

    public function createSystemAccount( $input );

    public function findCustomer( $id );
}