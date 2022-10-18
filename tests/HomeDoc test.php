<?php 
require_once('../views/HomeDoc.php');
$data = array(
    'page' => 'home',
    'menu' => array('home' => 'HOME', 'about' => 'ABOUT', 'contact' => 'CONTACT', 'webshop' => 'WEBSHOP'), 
    'sideMenu' => array('login' => 'Log In', 'register' => 'Sign Up')
);
$test = new HomeDoc($data);
$test->show();
?>