<?php
/**
 * Created by PhpStorm.
 * User : Tushar Khan
 * Year : 2018
 * Date : 2/15/2018
 * Time : 12:28 AM
 * File : helpers.php
 */
?>

<?php
    if ( ! function_exists('dnd') )
    {
        function dnd($data)
        {
            echo '<pre>';
            var_dump($data);
            echo '<pre>';
            die();
        }
    }


    if ( ! function_exists('sanitize') )
    {
        function sanitize($data)
        {
            return htmlentities($data, ENT_QUOTES, 'UTF-8');
        }
    }


    if ( ! function_exists('currentUsers') )
    {
        function currentUsers()
        {
            return Users::currentLoginUser();
        }
    }

?>