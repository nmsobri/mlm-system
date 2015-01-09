<?php

namespace Mlm\Interfaces;

interface UserInterface
{
    public function find( $id );

    public function getValidator();

    public function validate( $input );

    public function updateUserProfile( $input );

    public function updateLastLogin();

    public function createUser( $input );

    public function paginateUsers( $page, $per_page, $_user_id );

    public function findCustomer( $id );

    public function updateUser( $input );

    public function deleteUser( $id );

    public function isMaxDownline( $id );

    public function findUplines( $id );

    public function addUplinesPoint( $user );

    public function mandatoryPicture();
}