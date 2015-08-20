<?php

require_once ( Controller::path( 'home' ) );

class ErrorController extends Controller
{
	
	const CONTROLLER   = 'error';
	const DEFAULT_VIEW = 'not-found';
	
    public function notfound()
    {
        $this->redirect( HomeController::CONTROLLER );
    }
        
}