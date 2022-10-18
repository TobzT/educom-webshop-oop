<?php 
require_once('../views/DetailDoc.php');

$data = array(
    'page' => 'Webshop', 
    'id' => 1,
    'menu' => array('home' => 'HOME', 'about' => 'ABOUT', 'contact' => 'CONTACT', 'webshop' => 'WEBSHOP'), 
    'sideMenu' => array('login' => 'Log In', 'register' => 'Sign Up'), 
    'items' => array(array(1, 'Boerenbrood', 2.49, 'test desc', './Images/brood.jpg'))
);

$test = new DetailDoc($data);
$test->show();
?>