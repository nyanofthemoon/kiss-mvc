<?php

class UserAnswer extends Injectable
{

    const TABLE   = 'user_answer';
    const PRIMARY = 'user_answer_id';

    // INJECTABLES
    public $user_answer_id;
    public $user_id;
    public $value;

    public function __construct( Array $data = null )
    {
        if ( !empty( $data ) )
        {
            $this->_inject( $data );
        }
    }

}