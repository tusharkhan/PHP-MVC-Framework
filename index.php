<?php
/**
 * Created by PhpStorm.
 * User : Tushar Khan
 * Year : 2018
 * Date : 2/14/2018
 * Time : 11:11 PM
 * File : index.php
 */
?>

<?php
    //session_start();
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', dirname(__FILE__));

    require_once (ROOT . DS . 'app' . DS . 'lib' . DS . 'helpers' . DS . 'functions.php');

    // Autoload Classes
    /**
     * @param $className
     */
    function autoload($className)
    {
        if ( file_exists( ROOT . DS . 'core' . DS .  $className  . '.php') )
        {
            require_once (ROOT . DS . 'core' . DS .  $className  . '.php');
        }
        elseif ( file_exists( ROOT . DS . 'app' . DS . 'controllers' . DS .  $className  . '.php') )
        {
            require_once ( ROOT . DS . 'app' . DS . 'controllers' . DS .  $className  . '.php' );
        }
        elseif ( file_exists( ROOT . DS . 'app' . DS . 'models' . DS .  $className  . '.php') )
        {
            require_once ( ROOT . DS . 'app' . DS . 'models' . DS .  $className  . '.php' );
        }
    }

    spl_autoload_register('autoload');

    session_start();

    $url = isset( $_SERVER['PATH_INFO'] ) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [] ;
    //require_once (ROOT . DS . 'core' . DS . 'bootstrap.php');
    require_once (ROOT . DS . 'config' . DS . 'config.php');


//    $da = Database::getInstance();
//    dnd($da);
    //Route the Request
    Router::route($url);
?>