<?php

class Cache 
{

	// CLASS OBJECT CACHES
	const USER = 'user';
	
    public static function fetch( $cache, $id = null )
    {
    	$filepath = self::getCacheFilepath( $cache, $id );
		if ( file_exists( $filepath ) )
		{
			return unserialize( Loader::file( $filepath ) );
		}
		return null;
    }
	
    public static function store( $cache, $object, $id = null )
    {
    	return @file_put_contents( self::getCacheFilepath( $cache, $id ), serialize( $object ) );
    }
    
    private static function getCacheFilepath( $cache, $id = null )
    {
    	if ( is_null( $id ) )
    	{
    		return CAC . $cache . '.ser';
    	}
    	else
    	{
    		return CAC . $cache . '/' . $id . '.ser';
    	}
    }
    
    public static function hasCache( $cache )
    {
    	$reflection = new ReflectionClass( 'Cache' );
    	return in_array( $cache, $reflection->getConstants() );
    }
    
}