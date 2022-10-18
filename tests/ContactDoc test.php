<?php 
require_once('../views/FormsDoc.php');

$data = array(
    'page' => 'contact', 
    'submitLabel' => 'Submit',
    'menu' => array('home' => 'HOME', 'about' => 'ABOUT', 'contact' => 'CONTACT', 'webshop' => 'WEBSHOP'), 
    'sideMenu' => array('login' => 'Log In', 'register' => 'Sign Up'),
    'meta' => array(
            'gender' => array('label' => 'Aanspreeksvorm: ', 'type' => 'dropdown', 'options' => array("male" => "Dhr", "female" => "Mvr", "other" => "Anders"), 'validations' => array('notEmpty')),
            'name' => array('label' => 'Name: ', 'type' => 'text', 'validations' => array('onlyLetters', 'notEmpty')),
            'email' => array('label' => 'E-mail', 'type' => 'email', 'validations' => array('validEmail', 'notEmpty')),
            'tlf' => array('label' => 'Telefoon: ', 'type' => 'number', 'validations' => array('onlyNumbers', 'notEmpty')),
            'radio' => array('label' => 'Communicatievoorkeur: ', 'type' => 'radio', 'options' => array("tlf" => "Telefoon", "email" => "E-mail"), 'validations' => array('notEmpty')),
            'text' => array('label' => '', 'type' => 'textarea', 'validations' => array())
    )
);
$test = new FormsDoc($data);
$test->show();

?>