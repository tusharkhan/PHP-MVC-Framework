<?php
/**
 * Created by PhpStorm.
 * User : Tushar Khan
 * Year : 2018
 * Date : 2/15/2018
 * Time : 2:10 AM
 * File : Router.php
 */
?>

<?php
    class Router
    {
        public static function route($url)
        {
            //controller
            $controller = ( isset($url[0]) && !empty($url[0]) ) ? ucwords($url[0]) : DEFAULT_CONTROLLER;
            $controllerName = $controller;
            array_shift($url);

            //action
            $action = ( isset($url[0]) && !empty($url[0]) ) ? $url[0] . 'Action' : 'indexAction';
            $actionName = $action;
            array_shift($url);

            //params
            $queryParams = $url;

            $dispatch = new $controller( $controllerName, $action );

            if ( method_exists($controller, $action) )
            {
                call_user_func_array(array($dispatch, $action), $queryParams);
            }
            else
            {
                die('Method does not Exist " ' . $controllerName . ' " ');
            }
        }


        public static function redirect($location)
        {
            if ( ! headers_sent() )
            {
                header('Location: '.PROOT.$location);
                exit();
            }
            else
            {
                echo '<script>';
                    echo 'window.location.href="' . PROOT .$location . '";';
                echo '</script>';
                echo '<noscript>';
                    echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
                echo '</noscript>';
                exit;
            }
        }
    }
?>