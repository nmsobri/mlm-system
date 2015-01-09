<?php

namespace Mlm\Libs\Auth;

use Illuminate\Auth\EloquentUserProvider;

class MlmUserProvider extends EloquentUserProvider
{
    /**
     * Retrieve a user by the given credentials.
     * Add [is] index to Illuminate\Database\Query\Builder::operators
     * @param  array  $credentials
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function retrieveByCredentials( array $credentials )
    {
        $operator = '=';
        $query = $this->createModel()->newQuery();

        foreach ( $credentials as $key => $value ) {
            if( is_array( $value ) ) {
                $operator = $value['operator'];
                $value = $value['value'];
            }
            if ( ! str_contains( $key, 'password' ) ) $query->where( $key, $operator, $value );
        }
        return $query->first();
    }
}