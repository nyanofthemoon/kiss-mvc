<?php

class Loader 
{

    public static function library( $class )
    {
        $class = self::_formatClassName( $class ); 
        if( file_exists( APP . LIB . $class . EXT) ) 
        {
            require_once( APP. LIB . $class . EXT );
        }
        else
        {
            require_once( SYS. LIB . $class . EXT );
        }
    }

    public static function controller( $controller )
    {
        $filename = self::_formatViewName( $controller ); 
        $class = Controller::classname( $controller );
        if( file_exists( CTR . $filename . EXT) ) 
        {
            require_once( CTR . $filename . EXT );
            return new $class;
        }
        return new Controller();
    }

    public static function file( $path )
    {
        return @file_get_contents( $path );
    }

    public function view( $view, $data = array(), $as_string = false)
    {            
        $view = VIE . self::_formatViewName( $view ) . EXT;
        if( sizeof( $data ) > 0 )
        {
            extract( $data, EXTR_SKIP );
        }
        if ( file_exists( $view ) )
        {
            if( $as_string )
            {
                include( $view );
                $content = ob_get_contents();
                return $content;
            } else {
                include( $view );
            }
        }
        else
        {
            return false;
        }
        return true;
    }

    private static function _formatClassName( $class )
    {
        return ucfirst( strtolower( $class ) );
    }

    private static function _formatViewName( $view )
    {
        return strtolower( str_replace( '-', '', $view ) );
    }

}

?>