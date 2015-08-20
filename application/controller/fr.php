<?php

class FrController extends Controller
{

	const CONTROLLER   = 'fr';
	const DEFAULT_VIEW = 'fr';
	
    public function fr()
    {
    	Language::set(Language::FRENCH);	
    	header( 'Location: /' . Language::controller( Session::get( Cookie::CONTROLLER ), Language::FRENCH ) . '/' . Language::action( Session::get( Cookie::ACTION ) , Language::FRENCH ) , 302 );
    	exit;
    }
        
}