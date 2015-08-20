<?php

class EnController extends Controller
{

	const CONTROLLER   = 'en';
	const DEFAULT_VIEW = 'en';
	
    public function en()
    {
    	Language::set(Language::ENGLISH);
    	header( 'Location: /' . Language::controller( Session::get( Cookie::CONTROLLER ), Language::ENGLISH, true ) . '/' . Language::action( Session::get( Cookie::ACTION ), Language::ENGLISH, true ) , 302 );
    	exit;
    }
        
}