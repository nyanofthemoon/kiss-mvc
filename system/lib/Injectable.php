<?php

abstract class Injectable
{

    const ARRAY_SINGLE       = 'inject-as-array-single';
    const OBJECT_SINGLE      = 'inject-as-object-single';
    const ARRAY_MULTIPLE     = 'inject-as-array-multiple';
    const OBJECT_MULTIPLE    = 'inject-as-object-multiple';

    protected static $_inject_modes = array(
         self::ARRAY_SINGLE
        ,self::OBJECT_SINGLE
        ,self::ARRAY_MULTIPLE
        ,self::OBJECT_MULTIPLE
    );

    protected $_logging = true;
    private $_hash;
    private $_initial='';

    protected function _attributes()
    {
        $attributes = array_keys( get_class_vars( get_class( $this ) ) );
        foreach( $attributes as $key => $attribute )
        {
            if ( substr( $attribute, 0, 1 ) === '_' )
            {
                unset( $attributes[$key] );
            }
        }
        return $attributes;
    }

    protected function _inject( $injection )
    {
        if ( !empty( $injection ) )
        {
            $attributes = $this->_attributes();
            foreach( $injection as $key => $val )
            {
                if ( in_array( $key, $attributes) )
                {
                    $this->$key = stripslashes( $val );
                }
            }
        }
        if ( ENABLE_LOG )
        {
            $this->_hash = $this->_generateHash();
            switch ( get_class( $this ) )
            {
                case 'User':
                    $this->_initial = serialize(array(
                         'full_name' => $this->full_name
                        ,'gender'    => $this->gender
                        ,'email'     => $this->email
                        ,'dob'       => $this->dob
                        ,'address'   => $this->address
                        ,'city'      => $this->city
                    ));
                break;
                case 'UserAnswer':
                    $this->_initial = serialize(array(
                         'value' => $this->value
                    ));
                break;
                default: break;
            }
        }
    }

    public function _disableLogging()
    {
        $this->_logging = false;
        return $this;
    }

    public function _enableLogging()
    {
        $this->_logging = true;
        return $this;
    }

    private function _generateHash()
    {
        $hashable = '';
        foreach( $this->_attributes() as $attribute )
        {
            $hashable .= $this->$attribute;
        }
        return md5( $hashable );
    }

    private function _isDirty()
    {
        if ( $this->_hash != $this->_generateHash() )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function get( $data = null )
    {
        $class = get_called_class();
        return new $class( $data );
    }

    public static function load( Array $data )
    {
        return self::get( $data );
    }

    public function __call( $method, $args = null )
    {
        $method_order = explode( 'OrderBy', $method );
        preg_match('/^(select)|(update)|(delete)|(count)/', $method_order[0], $matches );
        if ( !empty( $matches[0] ) )
        {
            $class = get_class( $this );
            $query = Table::constructQuery( $class, $matches[0], $method, $args );
            switch( $matches[0] )
            {
                case 'count':
                    return reset( reset( Table::query( $query ) ) );

                case 'select':
                    if ( empty( $args[self::ARRAY_SINGLE] ) && empty( $args[self::OBJECT_SINGLE] ) && empty( $args[self::ARRAY_MULTIPLE] ) && empty( $args[self::OBJECT_MULTIPLE] ) )
                    {
                        if ( strstr( $method_order[0], 'All' ) === false )
                        {
                            $args[self::OBJECT_SINGLE] = true;
                        }
                        else
                        {
                            $args[self::OBJECT_MULTIPLE] = true;
                        }
                    }
                    foreach( self::$_inject_modes as $mode )
                    {
                        if ( !empty($args[$mode]) )
                        {
                            $inject_mode = $mode;
                            break;
                        }
                    }
                    $result = Table::query( $query );
                    if ( !empty( $result ) )
                    {
                        switch( $inject_mode )
                        {
                            case self::ARRAY_SINGLE:
                                return reset( $result );
                            case self::OBJECT_SINGLE:
                                $object = new $class( reset( $result ) );
                                if ( ENABLE_LOG && $this->_logging )
                                {
                                   Event::log( $object, Event::BROWSE, '', Session::getUser() );
                                }
                                return $object;
                            case self::ARRAY_MULTIPLE:
                                $collection = array();
                                foreach ( $result as $struct )
                                {
                                    $collection[] = $struct;
                                }
                                return $collection;
                            case self::OBJECT_MULTIPLE:
                                $collection = array();
                                foreach ( $result as $struct )
                                {
                                    $collection[] = new $class( $struct );
                                }
                                return $collection;
                        }
                    }
                    else
                    {
                        switch( $inject_mode )
                        {
                            case self::ARRAY_SINGLE:
                            case self::ARRAY_MULTIPLE:
                            case self::OBJECT_MULTIPLE:
                                return array();
                            case self::OBJECT_SINGLE:
                                return null;
                        }
                    }

                case 'update':
                    $primary_key = constant( $class . '::PRIMARY' );
                    if ( empty( $this->$primary_key ) )
                    {
                    	if ( method_exists( $this, '_onInsert' ) )
                    	{
                        	$this->_onInsert();
                        }
                    }
                    else
                    {
                        if ( method_exists( $this, '_onUpdate' ) )
                    	{
                        	$this->_onUpdate();
                        }
                    }
                    $args = get_object_vars( $this );
                    foreach ( $args as $arg => $val )
                    {
                        if ( substr( $arg, 0, 1 ) == '_' )
                        {
                            unset( $args[$arg] );
                        }
                    }
                    $query = Table::constructQuery( $class, $matches[0], $method, $args );
                    $result = Table::query( $query );
                    $primary = constant( $class . '::PRIMARY' );
                    if ( empty( $this->$primary ) )
                    {
                        $this->$primary = $result;
                        try
                        {
                        	if ( ENABLE_LOG && $this->_logging )
                        	{
                            	Event::log( $this, Event::CREATE, '', Session::getUser() );
                        	}
                        }
                        catch (Exception $exc)
                        {
                        }
                    }
                    else
                    {
                    	try {
                        	if ( ENABLE_LOG && $this->_logging )
                        	{
                            	$event = Event::get()->selectOneByEntityIdAndEntityAndActionOrderByDescTimestamp( $this->$primary, $class, Event::BROWSE );
								if ( !empty( $event ) )
								{
                            		if ( $this->_isDirty() )
                            		{
                                		$event->timestamp = time();
                                		$event->action = Event::MODIFY;
                                		$event->initial = str_replace( array("'", '"'), array('', "'"), $this->_initial );
                                		$event->update();
                            		}
                            		else
                            		{
                                		$event->delete();
                            		}
                            	}
                        	}
                        	
                        }
                        catch (Exception $exc)
                        {
                        }
                    }
                    return $result;

                case 'delete':
                    if ( empty( $args ) )
                    {
                        $primary = constant( $class . '::PRIMARY' );
                        $args = array( $this->$primary );
                        $method = 'deleteOneBy' . str_replace( ' ', '', ucwords( str_replace( '_', ' ', $primary ) ) );
                    }
                    if ( method_exists( $this, '_onDelete' ) )
                    {
                        $this->_onDelete();
                    }
                    $query = Table::constructQuery( $class, $matches[0], $method, $args );
                    try
                    {
                    	if ( ENABLE_LOG && $this->_logging )
                    	{
                        	Event::log( $this, Event::DELETE, $this->_initial, Session::getUser() );
                    	}
                    }
                    catch (Exception $exc)
                    {
                    }
                    return Table::query( $query );

            }
        }
    }

    public static function getCache( $id = null )
    {
        $class = get_called_class();
        $cache = constant( 'Cache::' . strtoupper( $class ) );
        if ( Cache::hasCache( strtolower( $cache ) ) )
        {
            $primary = constant( $class . '::PRIMARY' );
            if ( empty( $id ) )
            {
                $id = $this->$primary;
            }
            $object = Cache::fetch( $cache, $id );
            if ( is_null( $object ) )
            {
                $method = 'selectBy' . str_replace( ' ', '', ucwords( str_replace( '_', ' ', $primary) ) );
                $object = call_user_func( $class . '::get()->' . $method, $id );
                if ( !empty( $object->$primary ) )
                {
                    Cache::store( $cache, $object, $id );    
                }
            }
            return $object;
        }
        return null;
    }

    public static function setCache( $update = true )
    {
        $class = get_called_class();
        if ( Cache::hasCache( $class ) )
        {
            $primary = constant( $class . '::PRIMARY' );
            Cache::store( $class, $this, $this->$primary );
            if ( $update )
            {
                $this->update();
            }
            return true;
        }
        else
        {
            return false;
        }
    }

}