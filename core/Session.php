<?php
/**
 * Created by PhpStorm.
 * User : Tushar Khan
 * Year : 2018
 * Date : 2/19/2018
 * Time : 5:37 AM
 * File : Session.php
 */

    class Session
    {
        /**
         * @param $name
         * @return bool
         */
        public static function exist($name) { return ( isset( $_SESSION[$name] ) ) ? true : false; }


        /**
         * @param $name
         * @return mixed
         */
        public static function ger($name) { return $_SESSION[$name]; }


        /**
         * @param $name
         * @param $value
         * @return mixed
         */
        public static function set($name, $value) { return $_SESSION[$name] = $value; }


        /**
         * @param $name
         */
        public static function delete($name) { if ( self::exist($name) ) unset( $_SESSION[$name] ); }


        /**
         * @return mixed
         */
        public static function userAgent(){ return preg_replace("/\/[a-zA-Z0-9.]+/", '', $_SERVER['HTTP_USER_AGENT']); }
    }
?>