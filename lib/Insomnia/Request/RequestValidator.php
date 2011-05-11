<?php

namespace Insomnia\Request;

use \Insomnia\Registry;

class ValidatorException extends \Exception {}

class RequestValidator
{
    private $params = array(),
            $request;

    public function __construct()
    {
        $this->request = Registry::get( 'request' );
    }

    public function required( $key, $validator )
    {
        if( !isset( $this->request[ $key ] ) )
            throw new ValidatorException( $key . ' (required)' );
        
        $this->optional( $key, $validator );
        
    }

    public function optional( $key, $validator )
    {
        if( isset( $this->request[ $key ] ) )
        {
            $validator->validate( $this->request[ $key ], $key );
            $this->params[ $key ] = $this->request[ $key ];
        }
    }
    
    public function getParams()
    {
        return $this->params;
    }

    public function getParam( $key )
    {
        return isset( $this->params[ $key ] ) ? $this->params[ $key ] : null;
    }
}