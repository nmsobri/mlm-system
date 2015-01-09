<?php

namespace Mlm\Eloquents;

use Eloquent;

class Admin extends Eloquent
{

    use Validator;

    protected $table = 'admins';

    public $timestamps = false;

    protected $guarded = array();
}




