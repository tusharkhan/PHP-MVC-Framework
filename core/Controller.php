<?php
/**
 * Created by PhpStorm.
 * User : Tushar Khan
 * Year : 2018
 * Date : 2/15/2018
 * Time : 3:18 AM
 * File : Controller.php
 */
?>
<?php
    class Controller extends Application
    {
        protected $_controller;
        protected $_action;
        public $view;

        public function __construct($controller, $action)
        {
            parent::__construct();
            $this->_controller = $controller;
            $this->_action = $action;
            $this->view = new View();
        }

        protected function loadModel($modelName)
        {
            if ( class_exists($modelName) )
            {
                $this->{$modelName.'Model'} = new $modelName(strtolower($modelName));
            }
        }

    }
?>