<?php

class Permission
{

    private static $_list = array(
        User::GUEST => array(
             'home'             => array('welcome')
            ,'language'         => array('change')
            ,'error'            => array('notfound')
            ,'member'           => array('login', 'signup')
        ),
        User::USER => array(
             'home'             => array('welcome')
            ,'language'         => array('change')
            ,'error'            => array('notfound')
            ,'member'           => array('logout')
        ),
        User::ADMIN => array(
             'home'             => array('welcome')
            ,'language'         => array('change')
            ,'error'            => array('notfound')
            ,'member'           => array('logout')
        )
    );

    public static function validateAccess( $controller = DEFAULT_CONTROLLER, $action = null )
    {
        $controller = Language::controller($controller, Language::ENGLISH, true);
        if ( !empty( self::$_list[Session::getUserAccess()][$controller] ) )
        {
            $action = Language::action($action, Language::ENGLISH, true);
            if ( empty( $action ) || in_array( $action, self::$_list[Session::getUserAccess()][$controller] ) )
            {
                return true;
            }
        }
        return false;
    }

}