<?php
/**
 * Created by PhpStorm.
 * User : Tushar Khan
 * Year : 2018
 * Date : 2/15/2018
 * Time : 2:56 AM
 * File : Application.php
 */
?>
<?php
    class Application
    {
        public function __construct()
        {
            $this->_set_reporting();
            $this->_unregistered_globals();
        }

        private function _set_reporting()
        {
            if ( DEBUG )
            {
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
            }
            else
            {
                error_reporting(0);
                ini_set('display_errors', 0);
                ini_set('log_errors', 1);
                ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs'  . DS . 'errors.log');
            }
        }

        private function _unregistered_globals()
        {
            if ( ini_get('register_globals') )
            {
                $globalsArray = array('_SESSION', '_COOKIE', '_POST', '_GET', 'REQUEST', '_SERVER', '_ENV', '_FILES');
                foreach ($globalsArray as $glo)
                {
                    foreach ($GLOBALS[$glo] as $key => $value)
                    {
                        if ( $GLOBALS[$key] === $value )
                        {
                            unset( $GLOBALS[$key] );
                        }
                    }
                }
            }
        }
    }
?>