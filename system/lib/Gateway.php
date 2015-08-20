<?php

class Gateway
{

    public function bootstrap( $config = array() )
    {

		ob_start( 'ob_gzhandler' );
		
        try { $session = new Session(); } catch (Exception $ex) { echo $ex; }

        // Find Controller and Action
        try
        {
            $controller = DEFAULT_CONTROLLER;
            $action     = null;

            $route = str_replace(substr(WWW,0,-1), '', $_SERVER['SCRIPT_URI']);
            if ( !empty( $route ) )
            {
                $route_parts = explode( '/', substr( $route , 1) );
                if ( !empty( $route_parts[0] ) )
                {
                    $controller = $route_parts[0];
                }
                if ( !empty( $route_parts[1] ) )
                {
                    $action = $route_parts[1];
                }
                $query = $_SERVER['QUERY_STRING'];
                $query_parts = explode( '&', $query );
                foreach( $query_parts as $part )
                {
                    if ( !empty( $part ) )
                    {
                        $part = urldecode( $part );
                        $part_data = explode( '=', $part );
                        if ( !empty( $part_data[1] ) )
                        {
                            $_GET[$part_data[0]] = $part_data[1];
                        }
                        else
                        {
                            $_GET[$part] = $part;
                        }
                    }
                }
            }
        }
        catch ( Exception $exception )
        {
            $controller = ERROR_CONTROLLER;
        }
        
        //echo '<pre>';
        //echo $_SERVER['SCRIPT_URI'] . '<br>';
        //print_r($route_parts);
        //echo $controller.':'.$action;
        //exit;

        // Validate Controller and Action
        if ( !file_exists( Controller::path( $controller ) ))
        {
            $controller = ERROR_CONTROLLER;
        }
        require_once ( Controller::path( $controller ) );
        $class = Controller::classname( $controller );
        if ( empty( $action ) )
        {
            $action = constant( $class . '::DEFAULT_VIEW' ); 
        }

		// Format $_POST
		if ( !empty( $_POST ) )
		{
			foreach( $_POST as $key => $val )
			{
				if ( !is_array( $_POST[$key] ) )
				{
				    $_POST[$key] = stripslashes( $val );
				}
				else
				{
					foreach( $_POST[$key] as $kkey => $vval )
					{
						$_POST[$kkey] = stripslashes( $vval );
					}
				}
			}
		}

        // Set Browser
        $browser = Session::get( Cookie::BROWSER );
        //$browser = Cookie::get( Cookie::BROWSER );
        if ( empty( $browser ) )
        {
        	Session::set( Cookie::BROWSER, _set_browser() );
            //Cookie::set( Cookie::BROWSER, _set_browser() );
        }
        
        // Set Language
        $lang = Session::get( Cookie::LANGUAGE );
        if (empty($lang))
        {
        	$lang = Cookie::get( Cookie::LANGUAGE );
        }
        if ( empty( $lang ) )
        {
            Language::set();
        }

        // Omit Selection From Navigation
        if ( !in_array( Language::controller( $controller, Language::ENGLISH, true ), array( 'language', 'error' ) ) )
        {
        	//echo $controller.':'.$action;
            Session::set( Cookie::CONTROLLER, $controller );
            Session::set( Cookie::ACTION, $action );
            //Cookie::set( Cookie::CONTROLLER, $controller );
            //Cookie::set( Cookie::ACTION, $action );
        }

        // Validate User Access
        if (false === Permission::validateAccess( $controller, $action )) {
        	$controller = DEFAULT_CONTROLLER;
        	$action = '';
            require_once ( Controller::path( $controller ) );
        	$class = Controller::classname( $controller );
        	$action = constant( $class . '::DEFAULT_VIEW' ); 
        }

		//$_SERVER[ 'SERVER_SOFTWARE' ] = 'Blow-Fish 1.1.5';
		//header ( 'X-Powered-By: Blow-Fish 1.1.5', true );
		
        // Initiate
        call_user_func( array( new $class(), str_replace( '-', '', $action ) ) );

        if ( SHOW_DEBUG )
        {
            echo '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><pre>';
            echo '<br /><br /><br /><b>$_GET</b><br />';
            print_r( $_GET );
            echo '<br /><b>$_POST</b><br />';
            print_r( $_POST );
            echo '<br /><b>$_COOKIE</b><br />';
            print_r( $_COOKIE );
            echo '<br /><b>$_SESSION</b><br />';
            print_r( $_SESSION );
            echo '<br /><b>$_SERVER</b><br />';
            print_r( $_SERVER );
        }

        ob_end_flush();

    }

}