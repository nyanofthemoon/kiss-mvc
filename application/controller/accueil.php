<?php

require_once ( Controller::path( 'home' ) );

class AccueilController extends Controller
{

	const CONTROLLER   = 'accueil';
	const DEFAULT_VIEW = 'bienvenue';
	
    public function bienvenue()
    {
    	$this->redirect( HomeController::CONTROLLER );
    }
        
}