<?php

require_once ( Controller::path( 'member' ) );

class MembreController extends Controller
{

    const CONTROLLER   = 'membre';
    const DEFAULT_VIEW = 'ouvrirunesession';

    public function ouvrirunesession()
    {
        $this->redirect( MemberController::CONTROLLER, 'login' );
    }

    public function fermerlasession()
    {
    	$this->redirect( MemberController::CONTROLLER, 'logout' );
    }

    public function joindre()
    {
    	$this->redirect( MemberController::CONTROLLER, 'join' );
    }
    
    public function suivi()
    {
        $this->redirect( MemberController::CONTROLLER );
    }

}