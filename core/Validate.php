<?php
/**
 * Created by PhpStorm.
 * User : Tushar Khan
 * Year : 2018
 * Date : 2/21/2018
 * Time : 3:05 AM
 * File : Validate.php
 */

    class Validate
    {
        private $_passed = false;
        private $_erros = array();
        private $_db = null;

        public function __construct() { $this->_db = Database::getInstance(); }


        public function check($source, $items = array())
        {
            $this->_erros = array();

            foreach ($items as $item => $rules)
            {
                $item = Input::sanitize($item);
                $display = $rules['display'];

                foreach ($rules as $rule => $ruleValue)
                {
                    $value = Input::sanitize(trim($source[$item]));

                    if ( ( $rule === 'require' ) && ( empty( $value ) ) ) $this->addError(["{$display} is Required", $item]);
                    elseif ( ! empty( $value ) )
                    {
                        switch ($rule)
                        {
                            case 'min':
                                if ( strlen($value) < $ruleValue ) $this->addError([" {$display} must be minimum of {$ruleValue} characters ", $item]);
                                break;

                            case 'max' :
                                if ( strlen($value) > $ruleValue ) $this->addError([" {$display} must be maximum of {$ruleValue} characters ", $item]);
                                break;

                            case 'matches' :
                                if ( $value != $source[$ruleValue] )
                                {
                                    $matchDisplay = $items[$ruleValue]['display'];
                                    $this->addError([" {$matchDisplay} and {$display} must Match ", $item]);
                                }
                                break;

                            case 'unique' :
                                $checkQuery = $this->_db->query("SELECT {$item} FROM {$ruleValue} WHERE {$item} = ?", [$value]);

                                if ( $checkQuery->count() ) $this->addError([" {$display} already Exist "]);
                                break;

                            case 'is_numeric' :
                                if ( ! is_numeric( $value ) ) $this->addError([" {$display} must be a number", $item]);
                                break;

                            case 'valid_email' :
                                if ( ! filter_var($value, FILTER_VALIDATE_EMAIL) ) $this->addError([" {$display} is not valid E-mail ", $item]);
                                break;
                        }
                    }
                }
            }

            if ( empty( $this->_erros ) ) $this->_passed = true;
            return $this;
        }


        public function addError($error)
        {
            if ( is_array($error) )
            {
                $this->_erros[] = $error;

                if ( empty( $this->_erros ) ) $this->_passed = true;
                else $this->_passed = false;
            }
            //else $this->_erros = $error;
        }


        /**
         * @return array
         */
        public function error() { return $this->_erros; }


        /**
         * @return bool
         */
        public function passed() { return $this->_passed; }


        /**
         * @return string
         */
        public function displayErrors()
        {
            if ( ! empty( $this->_erros ) )
            {
                $html = "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12' ><div class='well'><ul class='margin-top'>";

                foreach ($this->_erros as $error)
                {
                    if ( is_array( $error ) )
                    {
                        $html .= "<li class='text-muted list-unstyled'>" . $error[0] . "</li>";
                        $html .= "<script>jQuery('document').ready( function() {
                                jQuery('#" . $error[1] ."').parent().closest('div').addClass('has-error');
                            } ); </script>";
                    }
                    else
                    {
                        $html .= "<li class='text-muted list-unstyled'>" . $error . "</li>";
                    }
                }

                $html .= "</ul></div></div>";
                return $html;
            }
        }

    }//Main Class
?>