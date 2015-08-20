<?php

class Registry
{
    
    private static $_objects = array();
    private static $_instance;
    
    private function __construct() {}
    private function __clone() {}
    
    public static function getInstance() 
    {
        if ( !isset( self::$_instance ) )
        {
        	self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public static function fetch( $key )
    {
        if ( isset( self::getInstance()->_objects[$key] ) )
        {
            return self::getInstance()->_objects[$key];
        }
        return null;
    }

    public static function store( $key, $val )
    {
        self::getInstance()->_objects[$key] = $val;
    }
    
}