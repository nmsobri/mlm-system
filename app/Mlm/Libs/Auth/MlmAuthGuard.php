<?php

namespace Mlm\Libs\Auth;

use Illuminate\Auth\Guard;

class MlmAuthGuard extends Guard
{

    public function set( $key, $val )
    {
        $this->session->put( $key, $val );
    }


    public function get( $key )
    {
        return $this->session->get( $key );
    }
}