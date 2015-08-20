<?php

class MemberController extends Controller
{
	
	const CONTROLLER = 'member';

	protected function _init()
	{
        parent::_init();
        if ( !Session::isLoggedIn() && !in_array( $this->action, array( 'login', 'ouvrirunesession', 'ouvrir-une-session', 'join', 'joindre', 'logout', 'fermer-la-session', 'fermerlasession' ) ) )
        {
            $this->login();
        }
	}
	
    public function login()
    {
        $this->includeJs( 'jquery/jquery-ui-1.8.1.min' );
        $this->includeCss( 'jquery/jquery-ui-1.8.1' );

    	if ( !empty( $_POST['username'] ) && !empty( $_POST['password'] ) ) 
    	{
    		$user = User::get()->selectOneByUsernameAndPassword( $_POST['username'], User::encryptPassword( $_POST['password'], $_POST['username'] ) );
    		if ( !empty( $user ) )
    		{
        		Session::set( Session::USER, $user );
        		if ( $user->access != User::ADMIN )
        		{
        			$this->load->view( self::CONTROLLER . '/' . self::DEFAULT_VIEW );
        		}
        		else
        		{
        			require_once ( Controller::path( 'admin' ) );
        			$this->redirect( AdminController::CONTROLLER, AdminController::DEFAULT_VIEW );
        		}
        	}
        	else
        	{
        		Session::_destroy();
        		$this->message->put( Language::gettext( 'login-error' ) );
        		$this->load->view( self::CONTROLLER . '/login' );
        	}
        }
        else
        {
        	$this->load->view( self::CONTROLLER . '/login' );
        }
    }
  
    public function logout()
    {
        @Session::_destroy();
        header( 'Location: ' . WWW, true, 302 );
    }

    public function join()
    {
    	if ( !empty( $_POST ) )
    	{
    		$valid = true;
    		if ( empty( $_POST['username'] ) )
    		{
    			$this->message->put( Language::gettext( 'login-empty-required-field', 'login-form-username' ) );
    			$valid = false;
    		}
    		if ( empty( $_POST['password'] ) )
    		{
    			$this->message->put( Language::gettext( 'login-empty-required-field', 'login-form-password' ) );
    			$valid = false;
    		}
     		if ( empty( $_POST['repassword'] ) || $_POST['password'] != $_POST['repassword'] )
    		{
    			$this->message->put( Language::gettext( 'login-empty-required-field', 'login-form-password-confirm' ) );
    			$valid = false;
    		}
    		else
    		{
    			if ( $valid )
    			{
    				if ( $_POST['password'] != $_POST['repassword'] )
    				{
    					$this->message->put( Language::gettext( 'login-required-password-confirm' ) );
    					$valid = false;
    				}
    			}
    		}
    		if ( empty( $_POST['full_name'] ) )
    		{
    			$this->message->put( Language::gettext( 'login-empty-required-field', 'login-form-username' ) );
    			$valid = false;
    		}
    		if ( empty( $_POST['gender'] ) )
    		{
    			$this->message->put( Language::gettext( 'login-empty-required-field', 'login-form-gender' ) );
    			$valid = false;
    		}
     		if ( empty( $_POST['dob'] ) )
    		{
    			$this->message->put( Language::gettext( 'login-empty-required-field', 'login-form-dob' ) );
    			$valid = false;
    		}
     		if ( empty( $_POST['sin'] ) )
    		{
    			$this->message->put( Language::gettext( 'login-empty-required-field', 'login-form-sin' ) );
    			$valid = false;
    		}    		
     		if ( empty( $_POST['email'] ) || !Validator::email( $_POST['email'] ) )
    		{
    			$this->message->put( Language::gettext( 'login-empty-required-field', 'login-form-email' ) );
    			$valid = false;
    		}    		
     		if ( empty( $_POST['phone_home'] ) && empty( $_POST['phone_cell'] ) && empty( $_POST['phone_work'] )  )
    		{
    			$this->message->put( Language::gettext( 'login-required-contact-info' ) );
    			$valid = false;
    		}      		
    		if ( $valid )
    		{
    			$session_user = Session::get( Session::USER );
    			$user = new User($_POST);
    			$user->created  = $session_user->created;
    			$user->last     = time();
    			$user->access   = User::MEMBER;
    			$user->password = User::encryptPassword( $_POST['password'], $_POST['username'] );
    			$user->update();
    		}
    		if ( !empty( $user->user_id ) )
    		{
    			Session::set( Session::USER, $user );
    		}
    	}
    	if ( !empty( $user->user_id ) && Session::isLoggedIn() )
    	{
    		$this->followup();
    	}
    	else
    	{
    		unset( $_POST['username'] );
    		unset( $_POST['password'] );
    		$this->login();
    	}
    }

    public function followup()
    {
        die('Hello!');
    }

}