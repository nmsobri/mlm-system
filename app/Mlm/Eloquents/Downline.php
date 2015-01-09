<?php

namespace Mlm\Eloquents;

use Eloquent;

class Downline extends Eloquent
{
    use Validator;

    protected $table = 'downlines';

    public $timestamps = false;

    protected $guarded = array();
}




