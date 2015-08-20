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
                         'first_name' => $this->first_name
                        ,'last_name'  => $this->last_name
                        ,'company'    => $this->company
                        ,'lang'       => $this->lang
                        ,'email'      => $this->email
                        ,'access'     => $this->access
                        ,'status'     => $this->status
                    ));
                break;
                case 'UserContact':
                    $this->_initial = serialize(array(
                         'info'       => $this->info
                        ,'is_primary' => $this->is_primary
                        ,'type'       => $this->type
                        ,'status'     => $this->status
                        ,'note'       => $this->note
                    ));
                break;
                case 'UserAddress':
                    $this->_initial = serialize(array(
                         'address'     => $this->address
                        ,'city'        => $this->city
                        ,'province'    => $this->province
                        ,'country'     => $this->country
                        ,'postal_code' => $this->postal_code
                        ,'is_primary'  => $this->is_primary
                        ,'type'        => $this->type
                        ,'status'      => $this->status
                    ));
                break;
                case 'UserProduct':
                    $this->_initial = serialize(array(
                         'serial_number' => $this->serial_number
                        ,'family'        => $this->family
                        ,'description'   => $this->description
                        ,'cosmetic'      => $this->cosmetic
                        ,'status'        => $this->status
                    ));
                break;
                case 'UserReference':
                    $this->_initial = serialize(array(
                         'type'        => $this->type
                        ,'description' => $this->description
                    ));
                break;
                case 'UserCase':
                    $this->_initial = serialize(array(
                         'agent_id'        => $this->agent_id
                        ,'user_id'         => $this->user_id
                        ,'user_contact_id' => $this->user_contact_id
                        ,'user_address_id' => $this->user_address_id
                        ,'user_product_id' => $this->user_product_id
                        ,'status'          => $this->status
                        ,'problem'         => $this->problem
                        ,'state'           => $this->state
                        ,'location'        => $this->location
                        ,'called'          => $this->called
                        ,'action_required'      => $this->action_required
                        ,'action_required_data' => $this->action_required_data
                    ));
                break;
                case 'AcknowledgementReceipt': 
                    $this->_initial = serialize(array(
                         'user_case_id'       => $this->user_case_id
                        ,'agent_id'           => $this->agent_id
                        ,'status'             => $this->status
                        ,'modified'           => $this->modified
                        ,'company_problem'    => $this->company_problem
                        ,'company_solution'   => $this->company_solution
                        ,'company_quote'      => $this->company_quote
                        ,'company_note'       => $this->company_note
                        ,'company_invoice'    => $this->company_invoice
                        ,'company_invoice_amount' => $this->company_invoice_amount
                        ,'recipient_name'     => $this->recipient_name
                        ,'recipient_contact'  => $this->recipient_contact
                        ,'recipient_address'  => $this->recipient_address
                        ,'recipient_problem'  => $this->recipient_problem
                        ,'recipient_solution' => $this->recipient_solution
                        ,'recipient_quote'    => $this->recipient_quote
                        ,'recipient_eta'      => $this->recipient_eta
                        ,'recipient_note'     => $this->recipient_note
                        ,'customer_paid'      => $this->customer_paid
                        ,'rstatus'            => $this->rstatus
                        ,'astatus'            => $this->astatus
                    ));
                break;       
                case 'Invoice':
                    $this->_initial = serialize(array(
                         'status'         => $this->status
                        ,'dd'             => $this->dd
                        ,'mm'             => $this->mm
                        ,'yyyy'           => $this->yyyy
                        ,'gst'            => $this->gst
                        ,'pst'            => $this->pst
                        ,'waive_gst'      => $this->waive_gst
                        ,'waive_pst'      => $this->waive_pst
                        ,'appointment_id' => $this->appointment_id
                        ,'user_id'        => $this->user_id
                        ,'user_case_id'   => $this->user_case_id
                        ,'note'           => $this->note
                        ,'getSubtotal'    => $this->getSubtotal()
                        ,'getGst'         => $this->getGst()
                        ,'getPst'         => $this->getPst()
                        ,'getTotal'       => $this->getTotal()
                        ,'getRefund'      => $this->getRefund()
                        ,'getDue'         => $this->getDue()
                    ));
                break;
                case 'InvoiceItem':
                    $this->_initial = serialize(array(
                         'type'        => $this->type
                        ,'title'       => $this->title
                        ,'description' => $this->description
                        ,'quantity'    => $this->quantity
                        ,'price'       => $this->price
                    ));
                break;
                case 'Appointment':
                    $this->_initial = serialize(array(
                    	 'user_id'         => $this->user_id
                        ,'user_address_id' => $this->user_address_id
                        ,'user_contact_id' => $this->user_contact_id
                        ,'period'          => $this->period
                        ,'time'            => $this->time
                        ,'status'          => $this->status
                        ,'type'            => $this->type
                        ,'kind'            => $this->kind
                    ));
                break;
                case 'Schedule':
                    $this->_initial = serialize(array(
                         'dd'         => $this->dd
                        ,'mm'         => $this->mm
                        ,'yyyy'       => $this->yyyy
                        ,'status'     => $this->status
                        ,'block_slot' => $this->block_slot
                    ));
                break;
                case 'Inventory':
                    $this->_initial = serialize(array(
                         'internal_upc' => $this->internal_upc
                        ,'upc'          => $this->upc
                        ,'title'        => $this->title
                        ,'description'  => $this->description
                        ,'state'        => $this->state
                        ,'status'       => $this->status
                        ,'location'     => $this->location
                        ,'model'        => $this->model
                        ,'origin'       => $this->origin
                        ,'date'         => $this->date
                        ,'price_buy'    => $this->price_buy
                        ,'price_sell'   => $this->price_sell
                    ));
                break;
                case 'Agent':
                    $this->_initial = serialize(array(
                         'badge'         => $this->badge 
                        ,'status'        => $this->status
                        ,'apple_tech_id' => $this->apple_tech_id
                    ));
                break;         
                case 'Note':
                    $this->_initial = serialize(array(
                         'entity_id' => $this->entity_id 
                        ,'entity'    => $this->entity
                        ,'user_id'   => $this->user_id
                        ,'status'    => $this->status
                        ,'access'    => $this->access
                        ,'title'     => $this->title
                        ,'content'   => $this->content
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