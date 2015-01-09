<?php

namespace Mlm\Eloquents;

use Eloquent;

class Profile extends Eloquent
{
    use Validator;

    protected $table = 'profiles';

    public $timestamps = false;

    protected $guarded = array();

    protected $primaryKey = 'user_id';
}




