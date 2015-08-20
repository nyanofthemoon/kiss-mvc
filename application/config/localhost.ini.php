<?php

// PHP
ini_set( 'session.save_path', '/tmp' );

// GLOBALS
define( 'SHOW_ERRORS', false );
define( 'SHOW_DEBUG', false );
define( 'ENABLE_LOG', true );
define( 'EXT', '.php' );

// FILE PATHS
define( 'SYS', '..' . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR );
define( 'APP', '..' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR );
define( 'LIB', APP . 'lib' . DIRECTORY_SEPARATOR );
define( 'CTR', APP . 'controller' . DIRECTORY_SEPARATOR );
define( 'VIE', APP . 'view' . DIRECTORY_SEPARATOR );
define( 'FRM', APP . 'form' . DIRECTORY_SEPARATOR );
define( 'PLG', APP . 'plugin' . DIRECTORY_SEPARATOR );

// WWW PATHS
define ( 'DOMAIN', 'localhost' );
define ( 'WWW', 'http://' . DOMAIN . '/' );
define ( 'IMG', WWW . 'img/' );
define ( 'CSS', WWW . 'css/' );
define ( 'JS', WWW . 'js/' );

// DATABASE
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_DATABASE', 'kissmvc' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', '' );

define ( 'CONTROLLER',         'controller' );
define ( 'DEFAULT_CONTROLLER', 'home' );
define ( 'ERROR_CONTROLLER',   'error' );

// WEBSITE
define ( 'EMAIL',  'support@fakewebsitedomaine.com' );
define ( 'NAME',   'Kiss MVC' );

// APPLICATION SETTINGS
define( 'VERSION', '0.5' );

// AUTOLOAD
function __autoload( $class )
{
    if ( file_exists( SYS . LIB . $class . EXT ) )
    {
        require_once( SYS . LIB . $class . EXT );
    }
    else if ( file_exists( APP . LIB . $class . EXT ) )
    {
        require_once( APP . LIB . $class . EXT );
    }
    else if ( file_exists( PLG . $class . EXT ) )
    {
        require_once( PLG . $class . EXT );
    }
}

?>