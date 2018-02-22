<?php
/**
 * Created by PhpStorm.
 * User : Tushar Khan
 * Year : 2018
 * Date : 2/15/2018
 * Time : 12:31 AM
 * File : config.php
 */
?>

<?php
    define('DEBUG', true);
    define('DB_NAME', 'id_card');  //Database Name
    define('DB_USER', 'root');  //Database User
    define('DB_HOST', '127.0.0.1');  //Database Host
    define('DB_PASS', '');  //Database Password
    define('CSS', '../css'); //CSS file
    define('JS', '../js'); //Js File

    define('DEFAULT_CONTROLLER', 'Home'); // Default Controller is Home
    define('DEFAULT_LAYOUT', 'default'); // if no layout is set controller use this layout
    define('SITE_TITLE', 'Framework'); // if no title is set use this site Title
    define('PROOT', '/mvc/');
    define('CURRENT_USER_SESSION', '$2y$10$xG62zNI/lDqp9j5QIAVn1ePoxvXmQ3Y9sNQ/B3Y2LwLHeWLH2HnfS');
    define('REMEBBER_ME_COOCKIE', 'mnbvcxzasdfghjklpoiuytrewq');
    define('REMEBBER_ME_COOCKIE_EXPIRE', 604800);
?>