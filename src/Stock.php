<?php

declare(strict_types= 1);

namespace PHPallas\Buffer;

use PHPallas\Utilities\ArrayUtility;

class Stock
{
    private static ? Stock $instance = NULL;
    private array $data = [];
    private array $helpers = [];
    private function __construct ()
    {
    }
    public static function getInstance (): static
    {
        if ( TRUE === is_null (static::$instance)) {
            static::$instance = new static ();
        }
        return static::$instance;
    }
    public function get ( string $name ): mixed
    {
        return ArrayUtility::get ( $this -> data, $name );
    }
    public function set ( string $name, mixed $value )
    {
        ArrayUtility::set ($this -> data, $name, $value );
    }
    public function register ( string $name, callable $function )
    {
        $this -> helpers [ $name ] = $function;
    }
    public function unregister ( string $name ): void
    {
        if ( TRUE === isset ( $this -> helpers [ $name ] ) ) {
            unset ( $this -> helpers [ $name ] );
        }
    }
    public function __call ( $method, $args = [] ): mixed
    {
        if ( TRUE === isset ( $this -> helpers [ $method ] ) ) {
            return call_user_func ( $this -> helpers [ $method ], $args );
        }
        return NULL;
    }
}