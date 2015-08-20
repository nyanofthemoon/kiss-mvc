<?php

class HomeController extends Controller
{
	
	const CONTROLLER   = 'home';
	const DEFAULT_VIEW = 'welcome';
	
	public $info;
	
    public function welcome()
    {   
        $this->load->view( self::CONTROLLER . '/' . self::DEFAULT_VIEW );
    }
        
}