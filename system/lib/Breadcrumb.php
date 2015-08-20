<?php

class Breadcrumb
{

	const SEPARATOR = '&nbsp;&nbsp;&raquo;&nbsp;&nbsp;';
	
	private $_controller;

	public function __construct( $controller )
	{
		$this->_controller = $controller;
	}
	
	public function generate()
	{
		$controller = $this->_controller->controller;
		$action     = $this->_controller->action;
		echo '<a href="' . Controller::url( $controller ) . '">' . ucwords( Language::controller( $controller ) ) . '</a>'  . self::SEPARATOR . ucwords( Language::action( $action ) );

	}

}

?>