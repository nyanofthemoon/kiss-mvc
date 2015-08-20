<?php

class Controller extends Loader 
{

    public $load;
    public $message;
    public $head_script = array();
    public $head_css = array();
    public $inline_script = array();
    public $browser;
    public $language;
    public $controller;
    public $action;

    public function __construct()
    {
        $this->load = $this;
        $this->_init();
    }

    protected function _init()
    {
        $this->browser    = Session::get( Cookie::BROWSER );
        $this->language   = Session::get( Cookie::LANGUAGE );
        $this->controller = Session::get( Cookie::CONTROLLER );
        $this->action     = Session::get( Cookie::ACTION );
        $this->message    = new Message();
        $this->includeJs( 'jquery/jquery-1.4.2.min' );
        $this->includeJs( 'jquery/jquery-ui-1.8.1.min' );
        $this->includeJs( 'jquery/jquery.validation-' . $this->language );
        $this->includeJs( 'jquery/jquery.validation' );
        $this->includeJs( 'flexigrid.pack' );
        $this->includeJs( 'common' );
        $this->includeCss( 'reset' );
        $this->includeCss( 'jquery/jquery-ui-1.8.1' );
        $this->includeCss( 'jquery/jquery.validation' );
        $this->includeCss( 'flexigrid/flexigrid' );
        $this->includeCss( 'common', true );
        //$this->browser =  Cookie::get( Cookie::BROWSER );
        //$this->language = Cookie::get( Cookie::LANGUAGE );
        //$this->controller = Cookie::get( Cookie::CONTROLLER );
        //$this->action = Cookie::get( Cookie::ACTION );
    }

    public function __call( $method, $args )
    {
        $this->load->view( ERROR_CONTROLLER . '/' . DEFAULT_ACTION );
    }

    public static function defaultAction( $controller )
    {
        $class = Controller::classname( $controller );
        Loader::controller( $controller );
        return constant( $class . '::DEFAULT_VIEW' );
    }

    public function redirect( $controller = null, $action = null )
    {
        if ( !isset( $controller ) )
        {
            $controller = DEFAULT_CONTROLLER;
        }
        if ( !isset( $action ) )
        {
            $action = self::defaultAction( $controller );
        }
        $controller_object = $this->load->controller( $controller );
		$controller_object->$action();
    }

    public static function url( $controller = null, $action = null, $params = null, $anchor = null, $echo = false )
    {
        if ( empty( $controller ) )
        {
            $controller = DEFAULT_CONTROLLER;
        }
        if ( empty( $action ) )
        {
            $action = self::defaultAction( $controller );
        }
        $language = Session::get( Cookie::LANGUAGE );
        //$language = Cookie::get( Cookie::LANGUAGE );
        $controller = Language::controller( $controller, $language );
        $action = Language::action( $action, $language );
        $url = WWW . $controller . '/' . $action;
        if ( gettype( $params ) == 'array' )
        {
            $url = $url . '?';
            foreach ( $params as $name => $value )
            {
                $url .= $name . '=' . $value . '&';
            }
        }
        if ( isset( $anchor ) )
        {
            $url .= '#' . $anchor;
        }
        if ( !$echo )
        {
            return $url;
        }
        else
        {
            echo $url;
        }
    }

    public static function ajax( $controller = null, $action = null, $params = null, $script = null, $obj_params = 'this.value', $anchor = null, $method = 'POST', $echo = false )
    {
        $url = 'javascript:request(' . "'" . $method . "'," . $script . ',' . $obj_params . ','."'" . self::url( $controller , $action , $params, $anchor ) . "')";
        if ( !$echo )
        {
            return $url;
        }
        else
        {
            echo $url;
        }
    }

    public static function path( $controller = '' )
    {
        return CTR . str_replace( '-', '', $controller ) . EXT;
    }

    public static function classname( $controller = '' )
    {
        $parts = explode( '-', strtolower( $controller ) );
        $class = '';
        foreach ( $parts as $part )
        {
            $class .= ucfirst( $part );
        }
        return $class . 'Controller';
    }

    public function includeCss( $file, $browser = false )
    {
        $this->head_css[] = array( 'file' => $file, 'browser' => $browser );
    }

    public function includeJs( $file )
    {
        $this->head_script[] = $file;
    }

}

?>