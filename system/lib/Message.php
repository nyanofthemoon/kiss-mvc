<?php

class Message
{
    
    const SPACE     = 'messages';
    const ERROR     = 'error';
    const WARNING   = 'warning';
    const SUCCESS   = 'success';
    
    protected $messages;
    
    public function __construct()
    {
        $messages = Session::get( self::SPACE );
        if ( !empty( $messages ) )
        {
            $this->messages = $messages;
        }
        else
        {
            $this->clear();
        }
    }
    
    public function put( $message, $type = self::ERROR )
    {
        $this->messages[] = array(
                                    'content' => $message,
                                    'class'   => $type
                                );
        Session::set( self::SPACE, $this->messages );
    }
    
    public function has_messages()
    {
        if ( count( $this->messages ) )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function show()
    {
        $messages = '';
        if ( count( $this->messages ) )
        {
            $messages .= '<ul>';
            foreach ( $this->messages as $message )
            {
                $messages .= '<li class="'.$message['class'].'">' . $message['content'] . '</li>';
            }
            $messages .= '</ul>';
            $this->clear();
        }
        echo $messages;
    }
    
    public function clear()
    {
        $this->messages = array();
        Session::set( self::SPACE, $this->messages );
    }
    
}