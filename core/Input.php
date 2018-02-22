<?php
/**
 * Created by PhpStorm.
 * User : Tushar Khan
 * Year : 2018
 * Date : 2/21/2018
 * Time : 2:34 AM
 * File : Input.php
 */

    class Input
    {
        public static function sanitize($data) { return htmlentities($data, ENT_QUOTES, 'UTF-8'); }


        public static function get($post)
        {
            if ( isset( $_POST[$post] ) ) return self::sanitize($_POST[$post]);
            elseif ( isset( $_GET[$post] ) ) return self::sanitize($_GET[$post]);
        }
    }
?>