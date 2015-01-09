<?php

namespace Mlm\Eloquents;

use Eloquent;

class Transaction extends Eloquent
{
    use Validator;

    protected $table = 'transactions';

    public $timestamps = false;

    protected $guarded = array();
}




