<?php
/**
 * Created by PhpStorm.
 * User : Tushar Khan
 * Year : 2018
 * Date : 2/19/2018
 * Time : 5:37 AM
 * File : Cookie.php
 */

    class Cookie
    {
        /**
         * @param $name
         * @param $key
         * @param $expire
         * @return bool
         */
        public static function set($name, $key, $expire)
        {
            if ( setcookie($name, $key, time()+$expire, '/') ) return true;
            return false;
        }


        /**
         * @param $name
         */
        public static function delete($name) { self::set($name, '', time()-1); }


        /**
         * @param $name
         * @return mixed
         */
        public static function get($name) { return $_COOKIE[$name]; }


        /**
         * @param $name
         * @return bool
         */
        public static function exist($name) { return isset($_COOKIE[$name]); }
    }
?>