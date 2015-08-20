<?php

function debug( $var, $exit = true )
{
	echo '<pre>';
	echo gettype( $var );
	echo '<br /><br />';
	print_r( $var );
	echo '<br />';
	var_dump( $var );
	echo '</pre>';
	if ( $exit )
	{
		exit;
	}
}

function _set_browser()
{
	$browser = array( 'browser'=>'', 'version'=>'' );
  	$known   = array('msie', 'firefox', 'safari', 'webkit', 'opera', 'netscape', 'konqueror', 'gecko');
  	$agent   = strtolower( $_SERVER['HTTP_USER_AGENT'] );
  	$pattern = '#(?<browser>' . join( '|', $known ) . ')[/ ]+(?<version>[0-9]+(?:\.[0-9]+)?)#';
    if ( preg_match_all( $pattern, $agent, $matches ) )
    {
    	$i = count($matches['browser'])-1;
  		$browser['browser'] = $matches['browser'][$i];
  		$browser['version'] = $matches['version'][$i];
	}
	$css_browser = $browser['browser'];
	switch ( $css_browser )
	{
		case 'safari':
		case 'msie':
			break;
		case 'webkit':
			$css_browser = 'safari';
			break;
		default:
			$css_browser = 'firefox';
			break;
	}
	Session::set( 'browser', $css_browser );
	//Cookie::set( 'browser', $css_browser );
	return $css_browser;
}

function shuffle_assoc( $array )
{
    $keys = array_keys( $array );
    shuffle( $keys );
    foreach( $keys as $key )
    {
        $new[$key] = $array[$key];
    }
    return $new;
}

function resume( $string, $max = 25, $ender = '...' )
{
	$string_length = strlen( $string );
	if ( $string_length <= $max )
	{
		return $string;
	}
	else
	{
		return substr( $string, 0, ( $max-strlen( $ender ) ) ) . $ender; 
	}
}

function natksort( $array )
{
    $keys = array_keys( $array );
    natsort($keys);
    foreach ( $keys as $k )
    {
        $new_array[$k] = $array[$k];
    }
    return $new_array;
}

function jsvar_format( $string )
{
	if ( strstr( $string, '"' ) === false )
	{
		return '"' . $string . '"';
	}
	else
	{
		return "'" . $string . "'";
	}
}

function strtoupper_i18n( $string )
{
	return str_replace( array('é','à','è','ê','ç','î','â'), array('É','À','È','Ê','Ç','Î','Â'), strtoupper( $string ) );
}

function ucfirst_i18n( $string )
{
	$string = ucfirst( $string );
	return str_replace( array('é','à','è','ê','ç','î','â'), array('É','À','È','Ê','Ç','Î','Â'), substr( $string, 0, 1 ) ) . substr ( $string, 1 );
}

function ucwords_i18n( $string )
{
	$string = ucwords( $string );
	$words  = explode( ' ', $string );
	foreach( $words as $pos_word => $word )
	{
		$words[$pos_word] = ucfirst_i18n( $word );
	}
	return implode( ' ', $words );
}

// Prior to PHP 5.3
if(!function_exists('get_called_class')) {
        class class_tools {
                static $i = 0;
                static $fl = null;

                static function get_called_class() {
                    $bt = debug_backtrace();

                        if (self::$fl == $bt[2]['file'].$bt[2]['line']) {
                            self::$i++;
                        } else {
                            self::$i = 0;
                            self::$fl = $bt[2]['file'].$bt[2]['line'];
                        }

                        $lines = file($bt[2]['file']);

                        preg_match_all('/([a-zA-Z0-9\_]+)::'.$bt[2]['function'].'/',
                            $lines[$bt[2]['line']-1],
                            $matches);

                return $matches[1][self::$i];
            }
        }

        function get_called_class() {
            return class_tools::get_called_class();
        }
}

?>