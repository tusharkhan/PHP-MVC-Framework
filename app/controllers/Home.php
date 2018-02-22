<?php
/**
 * Created by PhpStorm.
 * User : Tushar Khan
 * Year : 2018
 * Date : 2/15/2018
 * Time : 3:44 AM
 * File : Home.php
 */
?>
<?php

    class Home extends Controller
    {

        public function __construct($controller, $action)
        {
            parent::__construct($controller, $action);
            $this->view->setLayout('default');
        }


        public function indexAction()
        {
            $this->view->render('home/index');
        }
    }

?>