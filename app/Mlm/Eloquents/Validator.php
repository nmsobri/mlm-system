<?php

namespace Mlm\Eloquents;

use Validator as LaravelValidator;

trait Validator
{
    private $validator = null;

    private $errors = null;

    public function validate( array $data, $rules )
    {
        $this->validator = LaravelValidator::make( $data, $rules );
        if ( $this->validator->fails() ) {
            $this->errors = $this->validator->errors();
            return false;
        }
        return true;
    }


    public function errors()
    {
        return $this->errors;
    }


    public function getValidator()
    {
        return $this->validator;
    }
}