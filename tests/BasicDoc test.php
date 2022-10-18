<?php 
require_once('../views/BasicDoc.php');
$data = array('page' => 'Basic', 'menu' => array('home' => 'HOME', 'about' => 'ABOUT', 'contact' => 'CONTACT', 'webshop' => 'WEBSHOP'), 'sideMenu' => array('login' => 'Log In', 'register' => 'Sign Up'));
$test  = new BasicDoc($data);
$test->show();
?>