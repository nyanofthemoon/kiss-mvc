<?php

class User extends Injectable
{

    const TABLE   = 'user';
    const PRIMARY = 'user_id';

    // Access
    const GUEST    = 0;
    const MEMBER   = 1;
    const ADMIN    = 2;

    // Gender
    const GENDER_MALE   = 0;
    const GENDER_FEMALE = 1;

    // INJECTABLES
    public $user_id;
    public $username;
    public $password;
    public $access;
    public $created;
    public $last;
    public $full_name;
    public $gender;
    public $email;
    public $dob;
    public $birthplace;
    public $address;
    public $city;
    public $postal_code;
    public $occupation;

	public $_answers;

    public function __construct( Array $data = null )
    {
        if ( !empty( $data ) )
        {
            $this->_inject( $data );
            if ( !empty( $this->user_id ) )
            {
                $this->getAnswers();
            }
        }
    }

    public function getContacts()
    {
        $contacts = UserContact::get()->_disableLogging()->selectAllByUserIdAndStatusOrderByDescIsPrimary( $this->user_id, UserContact::ACTIVE );
        if ( empty( $contacts ) )
        {
            $contacts = array();
        }
        $this->_contacts = $contacts;
    }

    
    public static function encryptPassword( $password, $username='!@salt_IS-good$#' )
    {
        return sha1(
                    str_rot13(
                        base64_encode(
                            strrev( '37!t35@7T' . $password . $username . '3nC0D1ng' )
                        )
                    )
                );
    }

    public static function getGenders( $search = null )
    {
        $list = array(
             self::GENDER_MALE   => Language::gettext( 'user-male' )
            ,self::GENDER_FEMALE => Language::gettext( 'user-female' )
        );
        if ( is_null( $search ) )
        {
            return $list;
        }
        else
        {
            return $list[$search];
        }
    }

    public static function getAccesses( $search = null )
    {
        $list = array(
             self::MEMBER => Language::gettext( 'user-member' )
            ,self::ADMIN  => Language::gettext( 'user-admin' )
        );
        if ( is_null( $search ) )
        {
            return $list;
        }
        else
        {
            return $list[$search];
        }
    }

    public static function getLanguages( $search = null )
    {
        $list = array(
             Language::FRENCH  => Language::gettext( Language::FRENCH )
            ,Language::ENGLISH => Language::gettext( Language::ENGLISH )
        );
        if ( is_null( $search ) )
        {
            return $list;
        }
        else
        {
            return $list[$search];
        }
    }

    public static function generatePassword()
    {
        $password = '';
        $length = rand( 6, 10 );
        $letters = array_merge( range( 'a', 'n' ), range( 'p', 'z' ) );
        $letters_count = count( $letters );
        $numbers = range( 1, 9 );
        $numbers_count = count( $numbers );
        for ( $c = 0; $c < $length; $c++ )
        {
            if ( rand( 0, 2 ) != 1 )
            {
                if ( rand( 0, 2 ) != 0 )
                {
                    $password .= $letters[rand( 0, $letters_count )];
                }
                else
                {
                    $password .= ucfirst( $letters[rand( 0, $letters_count )] );
                }
            }
            else
            {
                $password .= $numbers[rand( 0, $numbers_count )];
            }
        }
        return $password;
    }

    public function getAnswers( $start_date = null, $end_date = null )
    {
        if ( !empty($start_date) && !empty($end_date) )
        {
        	$answers = Table::query('SELECT * from ' . UserAnswer::TABLE . ' WHERE a.user_id = ' . $this->user_id . ' AND a.timestamp >= "' . $start_date . '" AND a.timestamp <= "' . $end_date . '" ORDER BY a.timestamp DESC');
        }
        else if ( !empty($start_date) )
        {
        	$answers = Table::query('SELECT * from ' . UserAnswer::TABLE . ' WHERE a.user_id = ' . $this->user_id . ' AND a.timestamp >= "' . $start_date . '" ORDER BY a.timestamp DESC');
        }
        else if ( !empty($end_date) )
        {
        	$answers = Table::query('SELECT * from ' . UserAnswer::TABLE . ' WHERE a.user_id = ' . $this->user_id . ' AND a.timestamp <= "' . $end_date . '" ORDER BY a.timestamp DESC');
        }
        else
        {
        	$answers = Table::query('SELECT * from ' . UserAnswer::TABLE . ' WHERE a.user_id = ' . $this->user_id . ' ORDER BY a.timestamp DESC');
        }
        $this->_answers = $answers;
    }
    
}

?>