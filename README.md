PHP MVC Framework

To use this framework there is a config file like this

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

There is your Database Name

    define('DB_NAME', 'databasenaem');

There is your  Database Username

    define('DB_USER', 'username');

We used Database Host IP number , you can use your Database Host

    define('DB_HOST', 'yourhost');

There is our Database user password section

    define('DB_PASS', 'yourpassword');

You can put your CSS and JavaScript File in css and js folder.
To add your CSS and JS file you have to write like this

    //Load CSS file
    <link href="<?=CSS?>/custom.css" rel="stylesheet">


    //LOAD JavaScript File
    <script src="<?=JS?>/bootstrap.js"></script>
