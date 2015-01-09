<?php

namespace Mlm\Eloquents;

use Eloquent;

class Customer extends Eloquent
{
    use Validator;

    protected $table = 'customers';

    public $timestamps = false;

    protected $guarded = array();

    protected $primaryKey = 'user_id';
}




