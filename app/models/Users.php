<?php
/**
 * Created by PhpStorm.
 * User : Tushar Khan
 * Year : 2018
 * Date : 2/19/2018
 * Time : 11:15 PM
 * File : Users.php
 */

    class Users extends Model
    {
        private $_isLogIn;
        private $_sessionName;
        private $_cookieName;
        public static $currentLoginUser = null;

        public function __construct($user = '')
        {
            $table = 'user';
            parent::__construct($table);
            $this->_sessionName = CURRENT_USER_SESSION;
            $this->_cookieName = REMEBBER_ME_COOCKIE;
            $this->_softDelete = true;

            if ( $user != '' )
            {
                if ( is_int($user) ) $u = $this->_db->findFirst('user', array('conditions' => 'id = ?', 'bind' => [$user]));
                else $u = $this->_db->findFirst('user', array('conditions' => 'email = ?', 'bind' => [$user]));
            }

            if ($u)
            {
                foreach ($u as $key => $value)
                {
                    $this->$key = $value;
                }
            }
        }


        /**
         * @param $username
         * @return array|bool
         */
        public function findByUserName($username) { return $this->_db->findFirst('user', array('conditions' => 'email = ?', 'bind' => [$username])); }


        public function login($rememberMe = false)
        {
            Session::set($this->_sessionName, $this->id);

            if ( $rememberMe )
            {
                $hash = md5(uniqid() . rand(0, 100) );
                $userAgent = Session::userAgent();
                Cookie::set($this->_cookieName, $hash, REMEBBER_ME_COOCKIE_EXPIRE);

                $fields = array('session' => $hash, 'user_agent' => $userAgent, 'userID' => $this->id);
                $this->_db->query("DELETE * FROM user_session WHERE userID = ? AND user_agent = ?", [$this->id, $userAgent]);
                $this->_db->insert('user_session', $fields);
            }
        }


        public static function currentLoginUser()
        {
            if ( isset( self::$currentLoginUser ) ) return self::$currentLoginUser;
            elseif ( Session::exist(CURRENT_USER_SESSION) )
            {
                $user = new Users((int)Session::ger(CURRENT_USER_SESSION));
                self::$currentLoginUser = $user;
            }
            return self::$currentLoginUser;
        }


        public function logOut()
        {
            $userAjent = Session::userAgent();
            $this->_db->query("DELETE FROM user_session WHERE  user_id = ? AND user_agent = ? ", [$this->id, $userAjent]);
            Session::delete(CURRENT_USER_SESSION);

            if ( Cookie::exist(REMEBBER_ME_COOCKIE_EXPIRE) ) Cookie::delete(REMEBBER_ME_COOCKIE_EXPIRE);
            self::$currentLoginUser = null;
            return true;
        }

    }
?>