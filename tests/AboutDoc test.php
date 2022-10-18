<?php 
require_once('../views/AboutDoc.php');
$data = array(
            'page' => 'about', 
            'menu' => array('home' => 'HOME', 'about' => 'ABOUT', 'contact' => 'CONTACT', 'webshop' => 'WEBSHOP'), 
            'sideMenu' => array('login' => 'Log In', 'register' => 'Sign Up')
        );
$test = new AboutDoc($data);
$test->show();
?>