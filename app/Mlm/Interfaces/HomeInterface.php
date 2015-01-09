<?php

namespace Mlm\Interfaces;

interface HomeInterface
{
    public function getValidator();

    public function isAccountActive();

    public function validate( $input );

    public function landingPage( $group );

    public function attemptLogin( array $input, $remember );
}
