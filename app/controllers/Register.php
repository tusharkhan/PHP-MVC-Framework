<?php
/**
 * Created by PhpStorm.
 * User : Tushar Khan
 * Year : 2018
 * Date : 2/19/2018
 * Time : 4:13 AM
 * File : Register.php
 */

    class Register extends Controller
    {
        public function __construct($controller, $action)
        {
            parent::__construct($controller, $action);
            $this->loadModel('Users');
            $this->view->setLayout('default');
        }


        public function loginAction()
        {
            $validation = new Validate();
            if ( $_POST )
            {
                $validation->check($_POST, ['email' => ['display' => 'email', 'require' => true, 'valid_email' => true], 'password' => ['display' => 'Password', 'require' => true] ]);
                if ( $validation )
                {
                    $user = $this->UsersModel->findByUserName($_POST['email']);
                    //dnd($user);

                    if ( $user && password_verify(Input::get('password'), $user->password) )
                    {
                        $remember = ( isset( $_POST['rememberMe'] ) && $_POST['rememberMe'] ) ? true : false;
                        $user->login($remember);
                        Router::redirect('');
                    }
                    else
                    {
                        $validation->addError("There was an Error with your E-mail or Password");
                    }
//                    Router::redirect('home/index');
//                    exit();
                }
            }
            $this->view->displayErrors = $validation->displayErrors();
            $this->view->render('register/login');
        }
    }

?>