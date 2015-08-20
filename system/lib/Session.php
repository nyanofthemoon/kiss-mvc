<?php
 
class Session 
{

    const USER    = 'user';

    public function __construct()
    {
        $this->_start();
        $user = self::get( self::USER );
        if ( empty( $user ) )
        {
            $guest = new User( array(
                 'status'  => User::ACTIVE
                ,'access'  => User::GUEST
                ,'lang'    => Language::DEFAULT_LANGUAGE
                ,'gender'  => User::GENDER_NONE
                ,'created' => time()
            ));
            self::set( self::USER, $guest );
        }
        return $this;
    }

    public static function getUser()
    {
        return self::get( self::USER );
    }

    public static function isLoggedIn()
    {
        $user = self::getUser();
        if ( !empty( $user->user_id ) )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function getUserId()
    {
        $user = self::getUser();
        if ( !empty( $user->user_id ) )
        {
            return $user->user_id;
        }
        else
        {
            return 1;
        }
    }
    
    public static function getUserAccess()
    {
        $user = self::getUser();
        if ( !empty( $user->access ) )
        {
            return $user->access;
        }
        else
        {
            return User::GUEST;
        }
    }

    public static function getUserLanguage()
    {
        $user = self::getUser();
        if ( !empty( $user->lang ) )
        {
            return $user->lang;
        }
        else
        {
            return Language::ENGLISH;
        }
    }

    public static function set( $key, $val, $object_to_array = false )
    {
        if ( $object_to_array && gettype( $val ) == 'object' )
        {
            $val = get_object_vars( $val );
        }
        $_SESSION[$key] = $val;
    }

    public static function get( $key )
    {
        if( !empty( $_SESSION[$key] ) )
        {
            return $_SESSION[$key];
        }
        else
        {
            return null;
        }
    }

    private static function _start()
    {
        //@session_start();
    }

    public static function _unset()
    {
        $_SESSION = array();
        session_unset();
    }

    public static function _destroy()
    {
        session_destroy();
    }

}

?>