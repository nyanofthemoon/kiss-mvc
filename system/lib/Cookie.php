<?php
 
class Cookie 
{

	const LANGUAGE   = 'lang';
	const BROWSER    = 'browser';
	const CONTROLLER = 'controller';
	const ACTION     = 'action';

	public static function set( $key, $val )
	{
		$_COOKIE[$key] = $val;
		setcookie( $key, $val, (time()+(60*60*24*30)), '/' );
	}
    
	protected static function _unset()
	{
		$_COOKIE = array();
	}
    
	public static function get( $key )
	{
		if ( !empty( $_COOKIE[$key] ) )
		{
			return $_COOKIE[$key];
		}
		else
		{
			return false;
		}
	}
  
}