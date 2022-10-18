<?php 
require_once('../views/FormsDoc.php');
$data = array('page' => 'register', 
                'menu' => array('home' => 'HOME', 'about' => 'ABOUT', 'contact' => 'CONTACT', 'webshop' => 'WEBSHOP'), 
                'sideMenu' => array('login' => 'Log In', 'register' => 'Sign Up'), 
                'SubmitLabel' => 'Log In',
                'meta' => array(
                    'email' => array('label' => 'E-mail: ', 'type' => 'email', 'validations' => array('validEmail', 'notEmpty')),
                    'pw' => array('label' => 'Password: ', 'type' => 'password', 'validations' => array('correctPassword', 'notEmpty'))
                ));
$test = new FormsDoc($data);
$test->show();

?>