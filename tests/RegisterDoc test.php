<?php 
require_once('../views/FormsDoc.php');
$data = array('page' => 'register', 
                'menu' => array('home' => 'HOME', 'about' => 'ABOUT', 'contact' => 'CONTACT', 'webshop' => 'WEBSHOP'), 
                'sideMenu' => array('login' => 'Log In', 'register' => 'Sign Up'), 
                'SubmitLabel' => 'Sign up',
                'meta' => array(
                        'name' => array('label' => 'Name: ', 'type' => 'text', 'validations' => array('onlyLetters', 'notEmpty')),
                        'email' => array('label' => 'E-mail: ', 'type' => 'email', 'validations' => array('validEmail', 'notDuplicateMail', 'notEmpty')),
                        'pw' => array('label' => 'Password', 'type' => 'password', 'validations' => array('validPassword', 'notEmpty')),
                        'cpw' => array('label' => 'Confim Password', 'type' => 'password', 'validations' => array('equalField:pw', 'notEmpty'))
                ));
$test = new FormsDoc($data);
$test->show();

?>