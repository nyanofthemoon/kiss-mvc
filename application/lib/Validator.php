<?php

class Validator
{

    public static function email( $string )
    {
    	if ( false !== filter_var( $string, FILTER_VALIDATE_EMAIL ) )
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }
        
}

?>