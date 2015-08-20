<?php

class Table extends Database
{

    private static $_conditions = array
    (
        'And',
        'Or'
    );

    private static $_clauses = array
    (
        'Is',
        'In',
        'Not',
        'Between',
        'Greater',
        'Lower',
        'Than',
        'Equal'
    );

    private static $_clause_maps  = array
    (
        'Is'           => ' = %s',
        'Not'          => ' != %s',
        'IsNot'        => ' != %s',
        'In'           => ' IN( %s )',
        'NotIn'        => ' NOT IN( %s )',
        'Between'      => ' BETWEEN %s AND %s',
        'NotBetween'   => ' NOT BETWEEN %s AND %s',
        'GreaterEqual' => ' >= %s',
        'Greater'      => ' > %s',
        'LowerEqual'   => ' <= %s',
        'Lower'        => ' < %s'
    );

    private function __construct() {} 

    public static function get() 
    { 
        return new self();
    } 

    public static function query( $query, $ignore_format = false )
    {
    	if (false == $ignore_format)
    	{
        	if ( stristr( $query, 'update' ) === false && stristr( $query, 'insert' ) === false  )
        	{
            	$query = self::_formatOnSelect( $query );
        	}
        	else
        	{
            	$query = self::_formatOnUpdate( $query );
        	}
        }
        return Database::get()->_query( $query );
    }

    public static function constructQuery( $class, $type, $method, $args )
    {
        $table = constant( $class.'::TABLE' );
        $call  = 'construct' . ucfirst( $type );
        foreach ( $args as $key => $value )
        {
            $args[$key] = self::_formatString( $value );
        }
        $method = str_replace( 'select', '', $method );
        return self::$call( $table, $class, $method, $args );
    }

    private static function constructSelect( $table, $class, $method, $args )
    {
        return 'SELECT * FROM ' . $table . self::_getWhere( $method, $args ) . self::_getOrder( $method ) . self::_getLimit( $method );
    }

    private static function constructCount( $table, $class, $method, $args )
    {
        return 'SELECT COUNT(*) as total FROM ' . $table . self::_getWhere( $method, $args );
    }

    private static function constructDelete( $table, $class, $method, $args )
    {
        return 'DELETE FROM ' . $table . self::_getWhere( $method, $args ) . self::_getLimit( $method );
    }

    private static function constructUpdate( $table, $class, $method, $args )
    {
        if ( array_key_exists( 'last', $args ) )
        {
            $args['last'] = time();
        }
        $primary_key = constant( $class . '::PRIMARY' );
        if ( !empty( $args[$primary_key] ) && $args[$primary_key] !='""' && $args[$primary_key] != "''" )
        {
            $columns = array();
            foreach ( $args as $key => $value )
            {
                $columns[] = $key . ' = ' . $value;
            }
            return 'UPDATE ' . $table . ' SET ' . implode( ', ', $columns ) . ' WHERE ' . $primary_key . ' = ' . $args[$primary_key];
        }
        else
        {
            unset( $args[$primary_key] );
            return 'INSERT INTO ' . $table . ' ( ' . implode( ', ', array_keys( $args ) ) . ' ) VALUES ( ' . implode ( ', ', $args ) . ' )';
        }
    }

    private static function _getOrder( $method )
    {
        $method_order = explode( 'OrderBy', $method );
        $order_clause = '';
        if ( !empty( $method_order[1] ) )
        {
            $direction = 'Desc';
            if ( substr( $method_order[1], 0, 3 ) == 'Asc' )
            {
                $direction = 'Asc';
            }
            $method_order[1] = str_replace( $direction, '', $method_order[1] );
            $orders = explode( 'And', $method_order[1] );
            if ( !empty( $orders ) )
            {
                foreach( $orders as $key => $order )
                {
                    preg_match_all( '/[A-Z][^A-Z]*/', $order, $criterias );
                    $orders[$key] = strtolower( implode( '_', $criterias[0] ) );    
                }
                $order_clause = ' ORDER BY ' . implode( ',', $orders ) . ' ' . strtoupper( $direction );
            }
        }
        return $order_clause;
    }
    
    private static function _getLimit( $method )
    {
        if ( substr( $method, 0, 2 ) == 'By' || substr( $method, 0, 3 ) == 'One' )
        {
            return ' LIMIT 1';
        }
        return '';
    }
    
    private static function _getWhere( $method, $args )
    {
        $method_order = explode( 'OrderBy', $method );
        $method = str_replace( array( 'By','One','All' ), array( '', '', '' ), $method_order[0] );
        preg_match_all( '/[A-Z][^A-Z]*/', $method, $criterias );    
        $clauses    = array();
        $conditions = array();
        $parts      = array();
        $column     = null;
        $clause     = null;
        $j          = count( $criterias[0] );
        for( $i=0; $i<$j; $i++ )
        {
            $criteria = $criterias[0][$i];
            if( in_array( $criteria, self::$_conditions ) )
            {
                $parts[]      = $column;
                if ( empty( $clause ) )
                {
                    $clause = 'Is';
                }
                $clauses[]    = $clause;
                $conditions[] = $criteria;
                $column       = null;
                $clause       = null;
            }
            else
            {
                if ( !in_array( $criteria, self::$_clauses ) )
                {
                    if( is_null( $column ) )
                    {
                        $column = strtolower( $criteria );
                    }
                    else
                    {
                        $column .= strtolower( '_'. $criteria);
                    }
                }
                else
                {
                    if ( !empty( self::$_clause_maps[$clause.$criteria] ) )
                    {
                        $clause .= $criteria;
                    }
                } 
            }
            if ( $i+1 == $j)
            {
                $parts[] = $column;
                if( is_null( $clause ) )
                {
                    $clauses[] = 'Is';
                }
                else
                {
                    $clauses[] = $clause;
                }
            }
        }
        for( $i=0; $i<$j; $i++ )
        {
			if ( false !== strstr( self::$_clause_maps[$clauses[$i]], self::$_clause_maps['In'] ) )
			{
				$where .= sprintf( $parts[$i] . self::$_clause_maps[$clauses[$i]], $args[$i] ) . ' ' . strtoupper( $conditions[$i] ) . ' ';
			}
			else
			{
				$where .= vsprintf( $parts[$i] . self::$_clause_maps[$clauses[$i]], explode( ', ',  $args[$i]) ) . ' ' . strtoupper( $conditions[$i] ) . ' ';
			}
        }
        return ' WHERE ' . trim( $where );
    }

    private static function _formatString( $string )
    {
        if ( gettype( $string ) == 'array' )
        {
            $values = array();
            foreach ( $string as $value )
            {
                $values[] =  self::_quoteValue( $value );
            }
            $string = implode( ', ', $values );
        }
        else
        {
            $string = self::_quoteValue( $string );
        }
        return $string;
    }

    private static function _formatOnSelect( $value )
    {
        $value = str_replace( array('-'), array('imahyphen'), $value );
        $value = htmlentities( $value, ENT_NOQUOTES, 'UTF-8' );
        $value = preg_replace( '~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', $value );
        $value = preg_replace( array('~[^\w\s\r\n"%$#.,*=+_'."'".'():;/@&\\\\]~i', '~-+~'), ' ', $value );
        return str_replace( array('imahyphen','gt;','lt;','amp;','&<','&>'), array('-','>','<','&','<','>'), $value );
    }

    private static function _formatOnUpdate( $value )
    {
    	$value = str_replace( array('-','<','>'), array('imahyphen','',''), $value );
    	$value = strip_tags( $value );
        $value = htmlentities( $value, ENT_NOQUOTES, 'UTF-8' );
        $value = preg_replace( '~&([a-z]{1,2})(lig|slash|th|tilde);~i', '$1', $value );
        $value = preg_replace( array('~[^\w\s\r\n"%$#.,*=+_'."'".'():;/@&\\\\]~i', '~-+~'), ' ', $value );
        $value = html_entity_decode( $value );
        return utf8_encode( str_replace( array('imahyphen',' "'," '"), array('-','"',"'"), $value ) );
    }

    private static function _quoteValue( $value )
    {
        if ( !is_numeric( $value ) )
        {
        	if ( strstr( $value, "'" ) !== false )
        	{
            	$value = '"' . self::_escapeValue( $value ) . '"';
            }
            else
            {
            	$value = "'" . self::_escapeValue( $value ) . "'";
            }
        }
        return $value;
    }
    
    private static function _escapeValue( $value )
    {
        $search  = array("\x00",  "\\",   "'",  "\"",   "\x1a");
		$replace = array("\\x00", "\\\\", "\'", "\\\"", "\\\x1a");
		return str_replace($search, $replace, $value);
    }

}