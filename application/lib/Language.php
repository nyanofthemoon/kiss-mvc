<?php

class Language
{

    const FRENCH           = 'fr';
    const ENGLISH          = 'en';
    const DEFAULT_LANGUAGE = self::FRENCH;
    
    public static $list = array(
         self::FRENCH  => 'Français'
        ,self::ENGLISH => 'English'
    );
    
    public static function set( $lang = self::DEFAULT_LANGUAGE )
    {
        if ( !empty( $lang ) && in_array( $lang, array_keys( self::$list ) ) )
        {
            Session::set( Cookie::LANGUAGE, $lang );
            return $lang;
        }
        else
        {
            return self::DEFAULT_LANGUAGE;
        }
    }
    
    public static function controller( $name, $lang = null, $return_key_from_name = false )
    {
        $controller = array(
             'home'     => array( self::FRENCH => 'accueil', self::ENGLISH => 'home' )
            ,'language' => array( self::FRENCH => 'langue',  self::ENGLISH => 'language' )
            ,'fr'       => array( self::FRENCH => 'fr',      self::ENGLISH => 'fr' )
            ,'en'       => array( self::FRENCH => 'en',      self::ENGLISH => 'en' )
            ,'member'   => array( self::FRENCH => 'membre',  self::ENGLISH => 'member' )
        );
        if ( empty( $lang ) )
        {
        	$lang = Session::get( Cookie::LANGUAGE );
        }
        if ( $return_key_from_name )
        {
            $key = self::_returnKeyFromName( $name, $controller );
            if ( !empty( $key ) )
            {
                return $key;
            }
        }
        if ( isset( $controller[$name][$lang] ) )
        {
            return $controller[$name][$lang];
        }
        else
        {
            return $name;
        }
    }

    public static function action( $name, $lang = null, $return_key_from_name = false )
    {
        $action = array(
             'login'  => array( self::FRENCH => 'ouvrir-une-session', self::ENGLISH => 'login' )
            ,'join'   => array( self::FRENCH => 'joindre',            self::ENGLISH => 'join' )
            ,'logout' => array( self::FRENCH => 'fermer-la-session',  self::ENGLISH => 'logout' )
        );
        if ( empty( $lang ) )
        {
            $lang = Session::get( Cookie::LANGUAGE );
        }
        if ( $return_key_from_name )
        {
            $key = self::_returnKeyFromName( $name, $action );
            if ( !empty( $key ) )
            {
                return $key;
            }
        }
        if ( isset( $action[$name][$lang] ) )
        {
            return $action[$name][$lang];
        }
        else
        {
            return $name;
        }
    }
    
    private static function _returnKeyFromName( $name, $array )
    {
        foreach( $array as $key => $data )
        {
            if ( in_array( $name, array( $data[self::FRENCH], $data[self::ENGLISH] ) ) )
            {
                return $key;
            }
        }
        return null;
    }
    
    public static function gettext( $string, $params = null, $lang = null )
    {
        $translation = '';
        $string = strtolower( $string );
        if ( empty( $lang ) )
        {
        	$lang = Session::get( Cookie::LANGUAGE );
        }
        switch ( $string )
        {
            // GENERIC
            case 'yes':
                $translation = ( $lang == self::ENGLISH ? 'yes' : 'oui' );
                break;
            case 'no':
                $translation = ( $lang == self::ENGLISH ? 'no' : 'non' );
                break;
            case 'cancel':
                $translation = ( $lang == self::ENGLISH ? 'cancel' : 'annuler' );
                break;
            case 'add':
                $translation = ( $lang == self::ENGLISH ? 'add' : 'ajouter' );
                break;
            case 'edit':
                $translation = ( $lang == self::ENGLISH ? 'edit' : 'modifier' );
                break;
            case 'delete':
                $translation = ( $lang == self::ENGLISH ? 'delete' : 'effacer' );
                break;
            case 'submit':
                $translation = ( $lang == self::ENGLISH ? 'submit' : 'soumettre' );
                break;
            case 'search':
                $translation = ( $lang == self::ENGLISH ? 'search' : 'recherche' );
                break;
             case 'continue':
                $translation = ( $lang == self::ENGLISH ? 'continue' : 'continuer' );
                break;
                
            // LANGUAGE
            case self::FRENCH:
                $translation = ( $lang == self::FRENCH ? self::$list[self::FRENCH] : 'French' );
                break;
            case self::ENGLISH:
                $translation = ( $lang == self::FRENCH ? 'Anglais' : self::$list[self::ENGLISH] );
                break;

           // USER
           case 'member':
                $translation = ( $lang == self::ENGLISH ? 'member' : "membre" );
                break;
            case 'user-username':
                $translation = ( $lang == self::ENGLISH ? 'Username' : "Nom d'utilisateur" );
                break;
            case 'user-password':
                $translation = ( $lang == self::ENGLISH ? 'Password' : 'Mot de passe' );
                break;
            case 'user-fullname':
                $translation = ( $lang == self::ENGLISH ? 'name' : 'nom' );
                break;
            case 'user-contact':
                $translation = ( $lang == self::ENGLISH ? 'contact' : 'coordon�es' );
                break;
            case 'user-email':
                $translation = ( $lang == self::ENGLISH ? 'email' : 'courriel' );
                break;
            case 'user-address':
                $translation = ( $lang == self::ENGLISH ? 'address' : 'adresse' );
                break;
            case 'user-city':
                $translation = ( $lang == self::ENGLISH ? 'city' : 'ville' );
                break;
            case 'user-postalcode':
                $translation = ( $lang == self::ENGLISH ? 'postal code' : 'code postal' );
                break;
            case 'user-access':
                $translation = ( $lang == self::ENGLISH ? 'access' : 'acc�s' );
                break;
            case 'user-lang':
                $translation = ( $lang == self::ENGLISH ? 'language' : 'langue' );
                break;
            case 'user-last':
                $translation = ( $lang == self::ENGLISH ? 'last login' : 'derni�re connexion' );
                break;
            case 'user-created':
                $translation = ( $lang == self::ENGLISH ? 'member since' : 'membre depuis' );
                break;
            case 'user-male':
                $translation = ( $lang == self::ENGLISH ? 'male' : 'homme' );
                break;
            case 'user-female':
                $translation = ( $lang == self::ENGLISH ? 'female' : 'femme' );
                break;
            case 'user-gender':
                $translation = ( $lang == self::ENGLISH ? 'gender' : 'sexe' );
                break;

            // USER ACCESS
            case 'user-guest':
                $translation = ( $lang == self::ENGLISH ? 'guest' : 'invit�' );
                break;
            case 'user-member':
                $translation = ( $lang == self::ENGLISH ? 'member' : 'membre' );
                break;
            case 'user-admin':
                $translation = ( $lang == self::ENGLISH ? 'admin' : 'admin' );
                break;

            // LOGIN
            case 'login-ret-member':
                $translation = ( $lang == self::FRENCH ? 'Utilisateur Existant' : 'Returning Member' );
                break;
            case 'login-new-member':
                $translation = ( $lang == self::FRENCH ? 'Nouvel Utilisateur' : 'New Member' );
                break;
            case 'login-click-join':
                $translation = ( $lang == self::FRENCH ? 'Cliquez ici pour vous enregistrer' : 'Click Here to Register' );
                break;
            case 'login-form-username':
                $translation = ( $lang == self::FRENCH ? "Nom d'utilisateur" : 'Username' );
                break;
            case 'login-form-password':
                $translation = ( $lang == self::FRENCH ? 'Mot de passe' : 'Password' );
                break;
            case 'login-form-password-confirm':
                $translation = ( $lang == self::FRENCH ? 'Confirmez le mot de passe' : 'Confirm Password' );
                break;
            case 'login-form-dob':
                $translation = ( $lang == self::FRENCH ? 'Date de naissance' : 'Date of Birth' );
                break;
            case 'login-form-birthplace':
                $translation = ( $lang == self::FRENCH ? 'Lieu de naissance' : 'Birthplace' );
                break;
            case 'login-form-full_name':
                $translation = ( $lang == self::FRENCH ? 'Nom complet' : 'Full name' );
                break;
            case 'login-form-gender':
                $translation = ( $lang == self::FRENCH ? 'Sexe' : 'Gender' );
                break;
            case 'login-form-occupation':
                $translation = ( $lang == self::FRENCH ? 'Occupation' : 'Occupation' );
                break;
            case 'login-form-email':
                $translation = ( $lang == self::FRENCH ? 'Courriel' : 'Email' );
                break;
            case 'login-form-address':
                $translation = ( $lang == self::FRENCH ? 'Adresse' : 'Address' );
                break;
            case 'login-form-city':
                $translation = ( $lang == self::FRENCH ? 'Ville' : 'City' );
                break;
            case 'login-form-province':
                $translation = ( $lang == self::FRENCH ? 'Province' : 'Province' );
                break;
            case 'login-form-contact-info':
                $translation = ( $lang == self::FRENCH ? 'Informations de contacte' : 'Contact Information' );
                break;
            case 'login-empty-required-field':
                $translation = ( $lang == self::FRENCH ? 'requis' : 'required' );
                $translation = utf8_decode( self::gettext( $params ) ) . ' ' . $translation;
                break;
            case 'login-required-password-confirm':
                $translation = ( $lang == self::FRENCH ? 'Mot de passe et confirmation de mot de passe diff�rents' : 'Password and password confirmation do not match' );
                break;
            case 'login-required-contact-info':
                $translation = ( $lang == self::FRENCH ? 'Au moins un num�ro de t�l�phone requis' : 'At least one contact phone required' );
                break;
            case 'login-error':
                $translation = ( $lang == self::FRENCH ? "Informations d'identification invalides" : 'Invalid authentication credentials' );
                break;

            default:
                $translation = $string;
                break;
        }

        if ( !is_array( $translation ) )
        {
            $translation = utf8_encode( $translation );
        }
        else
        {
            foreach( $translation as $key => $data )
            {
                $translation[$key] = utf8_encode( $data );
            }
        }
        return $translation;
        
    }

}

?>