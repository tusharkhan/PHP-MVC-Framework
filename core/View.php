<?php
/**
 * Created by PhpStorm.
 * User : Tushar Khan
 * Year : 2018
 * Date : 2/15/2018
 * Time : 3:27 AM
 * File : View.php
 */
?>
<?php

/**
 * @property string displayErrors
*/
class View
    {
        protected $_head;
        protected $_body;
        protected $_siteTitle = SITE_TITLE;
        protected $_outputBuffer;
        protected $_layout = DEFAULT_LAYOUT;


        public function __construct()
        {

        }


        /**
         * @param $viewName
         */
        public function render($viewName)
        {
            $viewArray = explode('/', $viewName);
            $viewString = implode(DS, $viewArray);

            if ( file_exists(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php') )
            {
                include ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php';
                include ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . $this->_layout . '.php';
            }
            else
            {
                die('This view " ' .$viewName . ' " does not exist');
            }
        }


        public function content($type)
        {
            if ( $type == 'head' )
            {
                return $this->_head;
            }
            elseif ( $type == 'body' )
            {
                return $this->_body;
            }
            return false;
        }


        public function start($type)
        {
            $this->_outputBuffer = $type;
            ob_start();
        }


        public function end()
        {
            if ( $this->_outputBuffer == 'head' )
            {
                $this->_head = ob_get_clean();
            }
            elseif ( $this->_outputBuffer == 'body' )
            {
                $this->_body = ob_get_clean();
            }
            else
            {
                die('First run Start Method');
            }
        }

        public function setSiteTitle($title)
        {
            $this->_siteTitle = $title;
        }


        public function siteTitle()
        {
            return $this->_siteTitle;
        }


        public function setLayout($path)
        {
            $this->_layout = $path;
        }

    }
?>