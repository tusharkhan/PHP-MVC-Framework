<?php
/**
 * Created by PhpStorm.
 * User : Tushar Khan
 * Year : 2018
 * Date : 2/16/2018
 * Time : 8:47 AM
 * File : Tools.php
 */

    class Tools extends Controller
    {
        public function __construct($controller, $action)
        {
            parent::__construct($controller, $action);
            $this->view->setLayout('default');
        }


        public function indexAction()
        {
            $this->view->render('tools/index');
        }


        public function firstAction()
        {
            $this->view->render('tools/first');
        }


        public function secondAction()
        {
            $this->view->render('tools/second');
        }


        public function thirdAction()
        {
            $this->view->render('tools/third');
        }
    }