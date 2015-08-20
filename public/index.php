<?php

    define( 'CNF', 'application' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR );
    require_once ( CNF . 'localhost.ini.php' );
	@session_start();
	require_once ( SYS . 'common.php' );

    if ( !SHOW_ERRORS )
    {
        error_reporting( 0 );
    }
    else
    {
        error_reporting( E_ALL );
    }

    $gateway = new Gateway();
    $gateway->bootstrap();