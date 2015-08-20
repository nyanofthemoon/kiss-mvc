<?php

class Database
{

    private static $_db_instance    = null;
    private static $_db_connection  = null;
    private static $_last_insert_id = null;

    private function __construct() {} 
    private function __clone() {} 

    public static function get() 
    { 
        if ( !self::$_db_instance ) 
        { 
            self::$_db_instance = new self(); 
        }
        self::$_db_instance->_connect();
        return self::$_db_instance; 
    } 

    public static function lastInsertId()
    {
        return self::$_last_insert_id;
    }

    protected static function _connect()
    {
        if ( !self::$_db_connection ) 
        { 
            self::$_db_connection = mysql_connect( DB_HOST, DB_USER, DB_PASSWORD );
            self::$_db_instance->_select();
        }
    }

    protected static function _select()
    {
        mysql_select_db( DB_DATABASE, self::$_db_connection );
        mysql_set_charset( 'utf8' );
    }

    protected static function _query( $query )
    {
        if ( SHOW_DEBUG )
        {
            echo $query . '<br /><br />';
        }

        $result = mysql_query( $query, self::$_db_connection );
        if ( !isset ( $result ) || $result === false ) {
            return null;
        }

        if ( substr( $query, 0, 6 ) == 'INSERT' )
        {
            self::$_last_insert_id = @mysql_insert_id();
            return self::$_last_insert_id;
        }
        else
        {
            if ( !is_bool( $result ) )
            {
                $results=array();
                while( $row = mysql_fetch_assoc( $result ) )
                {
                    $results[] = $row;
                }
            }
            else
            {
                $results = $result;
            }
            @mysql_free_result( $result );
            return $results;
        }
    }
    
    protected static function _disconnect()
    {
        mysql_close( self::$_db_instance );
    }

}